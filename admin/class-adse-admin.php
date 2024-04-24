<?php

        // Register the admin menu and pages
        function adse_admin_menu() {
            // Add the main menu item (Info Page)
            add_menu_page(
                'ADSE Extension Info',
                'ADSE Extension',
                'manage_options',
                'adse-info',
                'adse_info_page',
                'dashicons-admin-generic',
                6
            );

            // Add the submenu for Category Management
            add_submenu_page(
                'adse-info', // Parent slug (main menu item)
                'Manage Categories',
                'Manage Categories',
                'manage_options',
                'adse-categories',
                'adse_categories_page'
            );

        }
        add_action('admin_menu', 'adse_admin_menu');

        // Function to display the Info Page
        function adse_info_page() {
            
            include_once plugin_dir_path( __FILE__ ). '/template/plugin-info.php';
        }

        // Function to display the Category Management Page
        function adse_categories_page() {

            if (!current_user_can('manage_options')) {
                return;
            }

            global $wpdb;
            $table_category = $wpdb->prefix . 'adse_category';
            
            echo '<div class="wrap">';
            
            
            // Handle form submissions for adding and deleting categories and data
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Add or delete category
                if (isset($_POST['add_category'])) {
                    $name = sanitize_text_field($_POST['category_name']);
                    $wpdb->insert($table_category, ['name' => $name]);
                    
                    echo '<span style="color:red">Category is added</span>';
                    
                } elseif (isset($_POST['delete_category'])) {
                    $category_id = intval($_POST['category_id']);
                    $wpdb->delete($table_category, ['id' => $category_id]);
                    
                    echo '<span style="color:red">Category is deleted</span>';
                }
            }

            // Display admin page content

            echo '<div class="wrap">';
            

            // Form for adding a new category
            echo '<h2>Add Category</h2>';
            echo '<form method="post">';
            echo '<input type="text" name="category_name" placeholder="Category Name" required>';
            echo '<input type="submit" name="add_category" value="Add Category" class="button button-primary">';
            echo '</form>';

            echo '<br /><br />';
            // List and delete data
            echo '<div><table border=1 width=800px><th>Category</th><th>&nbsp;</th>';
            
            $categories = $wpdb->get_results("SELECT * FROM $table_category");
            foreach ($categories as $category) {
                
                echo '<tr><td>' . esc_html($category->name) . '</td>';
                echo '<td><form method="post" style="display:inline;">';
                echo '<input type="hidden" name="category_id" value="' . esc_attr($category->id) . '">';
                echo '<input type="submit" name="delete_category" value="Delete" class="button button-secondary">';
                echo '</form></td></tr>';
            }

            echo '</div>';
            
            
            
            echo '</div>';
        }

        
