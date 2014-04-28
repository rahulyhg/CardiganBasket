<?php

class Maven_member_categories_model extends Maven_member_base_model {

	public function __construct() {
		parent::__construct();
	}
	

	function get_category_meta($category_id) {
		$option = get_option( "category_$category_id");

		return $option;
	}


	function update_category_meta ($category_id,$meta)
	{
            
		return update_option( "category_$category_id", $meta );
	}

	function get_post_categories()
	{
		$categories =  get_the_category();

		return $categories;
	}

	function get_all()
	{
		return get_categories(array('hide_empty'=>0,'hierarchical'=>true));
	}

	/**
	 * Get the parent categories
	 */
	function get_parents()
	{
		//TODO: Make it more efficient
		$categories = array();
		$categories_aux =  get_categories(array('hide_empty'=>0));

		foreach($categories_aux as $category)
		{
			if ($category->category_parent==0)
                            $categories[] = $category;
		}
		return $categories;
	}


	function delete_category_meta ($category_id,$meta_key)
	{
		$meta = $this->get_category_meta($category_id);

		if ($meta)
		{
			if(isset($meta[$meta_key]))
			{
				unset($meta[$meta_key]);
				$this->update_category_meta($category_id, $meta );
			}
		}
	}

	function add_category($name)
	{

		if (!category_exists($name))
			return wp_insert_category(array("cat_name"=>$name),true);

		return __("Already exists",maven_translation_key());
	}

	function update_category($category_id,$cat_name)
	{
		return wp_update_term($category_id,"category",array("name"=>$cat_name));
	}

	function edit_category($id,$name)
	{
		//get_category_to_edit
	}


	function delete_category($id)
	{
		return wp_delete_term( $id, 'category' );
	}

}

?>