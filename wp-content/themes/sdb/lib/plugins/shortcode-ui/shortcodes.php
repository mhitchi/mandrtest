<?php
/**
 * Shortcake UI
 */

	/** Shortcake associated with button shortcode */
	shortcode_ui_register_for_shortcode(

	/** Shortcode title */
	'button',

	array(
		'label' => 'Add Button',
		'listItemImage' => 'dashicons-admin-links',

		/** Shortcode Attributes */
		'attrs'         => array(
			array(
				'label'        => 'Button Text',
				'attr'         => 'text',
				'type'         => 'text',
				'description'  => 'This is the text that will appear inside the button',
			),
			array(
				'label'        => 'Mobile Text',
				'attr'         => 'mobile_text',
				'type'         => 'text',
				'description'  => 'Display different button text on mobile devices',
			),
			array(
				'label'        => 'Link',
				'attr'         => 'link',
				'type'         => 'url',
				'description'  => 'Full URL',
			),
			array(
				'label'        => 'Class',
				'attr'         => 'class',
				'type'         => 'text',
				'description'  => 'Add an optional CSS class to the button',
			),
			array(
				'label'        => 'New Tab',
				'attr'         => 'newtab',
				'type'         => 'select',
				'description'  => 'Will the button open in a new tab?',
				'options'	   => array(
						'false' 	=> esc_html__('Same Tab'),
						'true' 	=> esc_html__('New Tab'),
				),
			),
			array(
				'label'        => 'Align',
				'attr'         => 'align',
				'type'         => 'select',
				'description'  => 'How should the button be aligned?',
				'options'	   => array(
						'false' 	=> esc_html__('No Align'),
						'center' 	=> esc_html__('Center'),
						'left' 		=> esc_html__('Left'),
						'right' 	=> esc_html__('Right'),
				),
			),
			array(
				'label'        => 'Download',
				'attr'         => 'download',
				'type'         => 'select',
				'description'  => 'Is this a download link?',
				'options'	   => array(
					'false' 	=> esc_html__('No'),
					'true' 	=> esc_html__('Yes'),
				),
			)
		),

		/** You can select which post types will show shortcode UI */
		'post_type'     => array( 'post', 'page' ), 
		)
    );
    
    /** Shortcake associated with button shortcode */
	shortcode_ui_register_for_shortcode(

    /** Shortcode title */
    'heading',

    array(
        'label' => 'Add Heading',
        'listItemImage' => 'dashicons-edit',

        /** Heading Content **/
		'inner_content' => array(
			'label'        => esc_html__( 'Heading Text' ),
			'description'  => esc_html__( 'Place heading text here'),
		),

        /** Shortcode Attributes */
        'attrs'         => array(
            array(
                'label'        => 'Heading Type',
                'attr'         => 'tag',
                'type'         => 'select',
                'description'  => 'What type of heading should this be?',
                'options'	   => array(
                        'h1' 	=> esc_html__('Heading 1'),
                        'h2' 	=> esc_html__('Heading 2'),
                        'h3' 	=> esc_html__('Heading 3'),
                        'h4' 	=> esc_html__('Heading 4'),
                        'h5' 	=> esc_html__('Heading 5'),
                        'h6' 	=> esc_html__('Heading 6')
                ),
            ),
            array(
                'label'        => 'Heading Style',
                'attr'         => 'style',
                'type'         => 'select',
                'description'  => 'Change styling if you want the heading to look like another heading type.',
                'options'	   => array(
                        '' 	    => esc_html__('--'),
                        'h1' 	=> esc_html__('Heading 1'),
                        'h2' 	=> esc_html__('Heading 2'),
                        'h3' 	=> esc_html__('Heading 3'),
                        'h4' 	=> esc_html__('Heading 4'),
                        'h5' 	=> esc_html__('Heading 5'),
                        'h6' 	=> esc_html__('Heading 6')
                ),
            ),
            array(
                'label'        => 'Align',
                'attr'         => 'align',
                'type'         => 'select',
                'description'  => 'How should the heading be aligned?',
                'options'	   => array(
                        'false' 	=> esc_html__('No Align'),
                        'center' 	=> esc_html__('Center'),
                        'left' 		=> esc_html__('Left'),
                        'right' 	=> esc_html__('Right'),
                ),
            ),
        ),

        /** You can select which post types will show shortcode UI */
        'post_type'     => array( 'post', 'page' ), 
        )
    );

	/** Shortcake associated with Youtube shortcode */
	shortcode_ui_register_for_shortcode(

	/** Shortcode title */
	'email',

	array(
		'label' => 'Add Email Hyperlink',
		'listItemImage' => 'dashicons-email',

		/** Shortcode Attributes */
		'attrs'         => array(
			array(
				'label'        => 'Email',
				'attr'         => 'email',
				'type'         => 'text',
				'description'  => 'Add email link',
			),
			array(
				'label'        => 'Text',
				'attr'         => 'text',
				'type'         => 'text',
				'description'  => 'Add email text',
			),
			array(
				'label'        => 'Class',
				'attr'         => 'class',
				'type'         => 'text',
				'description'  => 'Apply a class',
			),
		),

		'post_type'     => array( 'post', 'page' ), 
		)
	);

	/** Shortcake associated with toggle shortcode */
	shortcode_ui_register_for_shortcode(
	'callout',

	array(
		'label' => 'Add Callout',
		'listItemImage' => 'dashicons-format-quote',

		/** Toggle Content **/
		'inner_content' => array(
			'label'        => esc_html__( 'Callout Text' ),
			'description'  => esc_html__( 'Content that will appear inside callout'),
		),

		'post_type'     => array( 'post', 'page' ), 
		)
	);

	/** Shortcake associated with toggle shortcode */
	shortcode_ui_register_for_shortcode(
	'toggle',

	array(
		'label' => 'Add Toggle',
		'listItemImage' => 'dashicons-arrow-down-alt',

		/** Shortcode Attributes */
		'attrs'         => array(
			array(
				'label'        => 'Title',
				'attr'         => 'title',
				'type'         => 'text',
				'description'  => 'This is the toggle\'s title',
			),
		),

		/** Toggle Content **/
		'inner_content' => array(
			'label'        => esc_html__( 'Toggle' ),
			'description'  => esc_html__( 'Content that will appear inside toggle'),
		),

		'post_type'     => array( 'post', 'page' ), 
		)
	);

	/** Shortcake associated with Youtube shortcode */
	shortcode_ui_register_for_shortcode(

	/** Shortcode title */
	'youtube',

	array(
		'label' => 'Add Youtube Video',
		'listItemImage' => 'dashicons-format-video',

		/** Shortcode Attributes */
		'attrs'         => array(
			array(
				'label'        => 'Link',
				'attr'         => 'link',
				'type'         => 'url',
				'description'  => 'Full URL',
			),
			array(
				'label'        => 'Image',
				'attr'         => 'image',
				'type'         => 'attachment',
				'libraryType'  => array( 'image' ),
				'description'  => 'Select an image',
			),
			array(
				'label'        => 'Align',
				'attr'         => 'align',
				'type'         => 'select',
				'description'  => 'How should the video be aligned?',
				'options'	   => array(
						'false' 	=> esc_html__('No Align'),
						'center' 	=> esc_html__('Center'),
						'left' 	=> esc_html__('Left'),
						'right' 	=> esc_html__('Right'),
				),
			),
		),

		'post_type'     => array( 'post', 'page' ), 
		)
	);

	/** Shortcake associated with Vimeo shortcode */
	shortcode_ui_register_for_shortcode(

	/** Shortcode title */
	'vimeo',

	array(
		'label' => 'Add Vimeo Video',
		'listItemImage' => 'dashicons-format-video',

		/** Shortcode Attributes */
		'attrs'         => array(
			array(
				'label'        => 'Link',
				'attr'         => 'link',
				'type'         => 'url',
				'description'  => 'Full URL',
			),
			array(
				'label'        => 'Image',
				'attr'         => 'image',
				'type'         => 'attachment',
				'libraryType'  => array( 'image' ),
				'description'  => 'Select an image',
			),
			array(
				'label'        => 'Align',
				'attr'         => 'align',
				'type'         => 'select',
				'description'  => 'How should the video be aligned?',
				'options'	   => array(
						'false' 	=> esc_html__('No Align'),
						'center' 	=> esc_html__('Center'),
						'left' 	=> esc_html__('Left'),
						'right' 	=> esc_html__('Right'),
				),
			),
		),

		'post_type'     => array( 'post', 'page' ), 
		)
	);