<?php

namespace App\Traits;
use Illuminate\Http\Request;
//use App\Model\AttributesMapping;
use DB;

trait AttributesTrait {
	
	public function getAttributesMapping($entity_type, $func_type='create_func') {
		//return AttributesMapping::where('entity_type', '=', $entity_type)->get();
		
		 return DB::table('attributes_mappings')
			->select('attributes_mappings.attribute_id', 'attributes_mappings.title', 'attributes_mappings.field_type', 'attributes_mappings.default_value', 'attributes_groups.title as group_title', 'attributes_groups.slug as group_slug', 'attributes_groups.position as group_position', 'attributes_groups.is_collapse as group_collapse', 'attributes.slug as attribute_machine_name', 'attributes.type as attribute_value_type', 'attributes_mappings.validation_rule', 'attributes_mappings.placeholder', 'attributes_mappings.help_text', 'attributes_mappings.pattern', 'attributes_mappings.select_data', 'attributes_mappings.multiple', 'attributes_mappings.extra')
			->join('attributes_groups','attributes_groups.id','=','attributes_mappings.attributes_group_id')
			->join('attributes','attributes.id','=','attributes_mappings.attribute_id')
			->whereRaw("find_in_set('{$entity_type}',entity_type)")
			//->where('entity_type', 'like', "%{$entity_type}%")
			->where($func_type, '=', 1)
			//->where(['entity_type' => $entity_type, $func_type => 1])
			->get();
		
	}
	
	public function getAttributes($entity_type, $fields=[], $func_type='create_func') {
		//print_r($fields);
		$attributes = $this->getAttributesMapping($entity_type, $func_type);
		foreach($attributes as $attribute) {
			//print_r($attribute); die;
			
			$select_data = [];
			if(!empty($attribute->select_data)) {
				$select_data_arr = json_decode($attribute->select_data);
				$query = $select_data_arr->model::query()->select(explode(',',$select_data_arr->fields)) ;
				foreach($select_data_arr->where as $where) {
					$query = $query->where($where->col_name, $where->col_operator, $where->col_value);
				}
				$pluck_fields = explode(",", $select_data_arr->pluck);
				$select_data = $query->pluck($pluck_fields[0],$pluck_fields[1]);
				//print_r($data);
				//die;
				
			}
			
			$default_value = null;
			if(!empty($attribute->default_value)) {
				$default_value = json_decode($attribute->default_value);
				if (json_last_error() === JSON_ERROR_NONE) {
					
				}
				else {
					$default_value = $attribute->default_value;
				}
			}
			
			$extra = [];
			if(!empty($attribute->extra)) {
				$extra = json_decode($attribute->extra);
				//$x['media_type'] = 'image';
				//$x['sortable'] = 1;
				//echo json_encode($x); die;
				//print_r($extra);
			}
		
			$attribute_fields = ['label_text' => $attribute->title, 'column_name' => $attribute->attribute_machine_name, 'type' => $attribute->attribute_value_type, 'input_type' => $attribute->field_type, 'default_value' => $default_value,'validation' => $attribute->validation_rule, 'placeholder' => $attribute->placeholder, 'help_text' => $attribute->help_text, 'pattern' => $attribute->pattern, 'select_data' => $select_data, 'multiple' => (bool) $attribute->multiple, 'extra'=>$extra];
			
			if(!isset($fields[$attribute->group_position][$attribute->group_slug])) {			
				$fields[$attribute->group_position][$attribute->group_slug] = (object) [];
				$fields[$attribute->group_position][$attribute->group_slug]->group_prop = ['title' => $attribute->group_title, 'collapse' => $attribute->group_collapse];
			}
			$fields[$attribute->group_position][$attribute->group_slug]->fields[] = $attribute_fields ;
		}
		//print_r($fields); die;
		return $fields;
	}
	
	
	
	public function getAttributeData($entity_type, $content_id, $resultp) {
		$data = [];
		
		$result = DB::table('attributes_mappings')
			->select('attributes.slug', 'attribute_integer_values.content')
			->join('attributes','attributes.id','=','attributes_mappings.attribute_id')
			->join('attribute_integer_values','attribute_integer_values.attribute_id','=','attributes_mappings.attribute_id')
			->where(['attribute_integer_values.entity_type' => $entity_type, 'attribute_integer_values.content_id' => $content_id])
			-> union(DB::table('attributes_mappings')
				->select('attributes.slug', 'attribute_varchar_values.content')
				->join('attributes','attributes.id','=','attributes_mappings.attribute_id')
				->join('attribute_varchar_values','attribute_varchar_values.attribute_id','=','attributes_mappings.attribute_id')
				->where(['attribute_varchar_values.entity_type' => $entity_type, 'attribute_varchar_values.content_id' => $content_id]))
			->union(DB::table('attributes_mappings')
				->select('attributes.slug', 'attribute_boolean_values.content')
				->join('attributes','attributes.id','=','attributes_mappings.attribute_id')
				->join('attribute_boolean_values','attribute_boolean_values.attribute_id','=','attributes_mappings.attribute_id')
				->where(['attribute_boolean_values.entity_type' => $entity_type, 'attribute_boolean_values.content_id' => $content_id]))
			->union(DB::table('attributes_mappings')
				->select('attributes.slug', 'attribute_text_values.content')
				->join('attributes','attributes.id','=','attributes_mappings.attribute_id')
				->join('attribute_text_values','attribute_text_values.attribute_id','=','attributes_mappings.attribute_id')
				->where(['attribute_text_values.entity_type' => $entity_type, 'attribute_text_values.content_id' => $content_id]))
			->union(DB::table('attributes_mappings')
				->select('attributes.slug', 'attribute_datetime_values.content')
				->join('attributes','attributes.id','=','attributes_mappings.attribute_id')
				->join('attribute_datetime_values','attribute_datetime_values.attribute_id','=','attributes_mappings.attribute_id')
				->where(['attribute_datetime_values.entity_type' => $entity_type, 'attribute_datetime_values.content_id' => $content_id]))
			->union(DB::table('attributes_mappings')
				->select('attributes.slug', 'attribute_relational_values.content')
				->join('attributes','attributes.id','=','attributes_mappings.attribute_id')
				->join('attribute_relational_values','attribute_relational_values.attribute_id','=','attributes_mappings.attribute_id')
				->where(['attribute_relational_values.entity_type' => $entity_type, 'attribute_relational_values.content_id' => $content_id]))
			->get();
		
	
		//print_r($result); die;
		foreach($result as $row) {
			$content_data = json_decode($row->content);
			if (json_last_error() === JSON_ERROR_NONE) {
				$data[$row->slug] = $content_data;
			}
			else {
				$data[$row->slug] = $row->content;
			}
		}
		
		//print_r($resultp);
		
		foreach($resultp as $k=>$rowp) {
			$data[$k] = $rowp;
		}
		
		//print_r($data);
		//$collection = collect([$data]);
		
		//return $collection;
		return $data;
		
	}
	
	public function saveAttributeData($request, $entity_type, $content_id) {
	
		$fields = $this->getAttributesMapping($entity_type);
		
		//print_r($fields); die;
		
		foreach($fields as $field) {
			//echo 'attribute_' . $field->attribute_value_type . '_values'; die;
			//echo str_replace('[]','',$field->attribute_machine_name);
			$content_data = $request->{$field->attribute_machine_name};
			if(is_array($content_data)) {
				$content = json_encode($content_data);
			}
			else {
				$content = $content_data;
			}
			//echo $content; die;
			
			DB::table('attribute_' . $field->attribute_value_type . '_values')
				->updateOrInsert(
					['attribute_id' => $field->attribute_id, 'entity_type' => $entity_type, 'content_id' => $content_id],
					['content' => $content]
				);
		}
		
		return TRUE;	
	}
	
	
	
}