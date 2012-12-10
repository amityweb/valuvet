<?php
$cfg['input_types']=array(
                        array(
                            'name'=>'Text line',
                            'type'=>'text',
                            'value'=>'',
                            'id'=>TF_THEME_PREFIX."_%%name%%",
                            'options'=>false,
                            'properties'=>array(
                                'style'=>'width:85%',
                                'class'=>'inputtext input_middle'
                            )
                            ),
                        array(
                            'name'=>'Text area',
                            'type'=>'textarea',
                            'value'=>'',
                            'id'=>TF_THEME_PREFIX."_%%name%%",
                            'options'=>false,
                            'properties'=>array(
                                'style'=>'width:91%',
                                'class'=>'textarea'
                            )
                             ),

                        array(
                             'name'=>'Radio buttons',
                             'type'=>'radio',
                             'value'=>'',
                             'id'=>TF_THEME_PREFIX."_%%name%%",
                             'options'=>true
                             ),
                        array(
                             'name'=>'Checkbox',
                             'type'=>'checkbox',
                             'value'=>'',
                             'id'=>TF_THEME_PREFIX."_%%name%%",
                             'options'=>false
                             ),
                         array(
                             'name'=>'Select Box',
                             'type'=>'select',
                             'value'=>'',
                             'id'=>TF_THEME_PREFIX."_%%name%%",
                             'properties'=>array(
                                 'class'=>'select_styled'
                             ),
                             'options'=>true
                              ),
                         array(
                             'name'=>'Email',
                             'type'=>'text',
                             'value'=>'',
                             'id'=>TF_THEME_PREFIX."_%%name%%",
                             'options'=>false,
                             'properties'=>array(
                                 'style'=>'width:85%'
                             )
                             ),
                         array(
                              'name'=>'Captcha',
                              'type'=>'captcha',
                              'value'=>'',
                              'id'=>"captcha",
                              'options'=>false,
                              'file_name'=>'captcha_gen.php',
                             'properties'=>array(
                                 'style'=>'width:85%'
                             )
                              )
                        );
$cfg['labels']=array(
            'type'=>'tfuse_cf_label',
    array(
        'id'=>'cf_type',
        'html'=>'<label >Type</label>',
        'type'=>'raw'
    ),
            array(
                'id'=>'cf_label',
                'html'=>'<label >Label</label>',
                'type'=>'raw'
            ),

            array(
                'id'=>'cf_width',
                'html'=>'<label >Width (%)</label>',
                'type'=>'raw'
            ),
            array(
                'id'=>'cf_required',
                'html'=>'<label >Required</label>',
                'type'=>'raw'
            ),
            array(
                'id'=>'cf_newline',
                'html'=>'<label >New Line</label>',
                'type'=>'raw'
            ),
            array(
                'id'=>'cf_shortcode',
                'html'=>'<label >Shortcode</label>',
                'type'=>'raw'
            ),
        );