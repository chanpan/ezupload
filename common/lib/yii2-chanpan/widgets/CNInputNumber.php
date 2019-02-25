<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace cpn\chanpan\widgets;

/**
 * Description of CNInputNumber
 *
 * @author chanpan
 */
class CNInputNumber extends \yii\base\Widget{
    public $data_id;
    public $default_value;
    //put your code here
    public function init()
    {
        $this->default_value = isset($this->default_value)?$this->default_value:1;
    }
    public function run()
    {
        $template = "
          <div class='input-group'>
            <span class='input-group-btn'>
              <button class='btn btn-default btn-sub' data-id={$this->data_id} type='button' id='btn-sub-{$this->data_id}'>-</button>
            </span>
            <input data-id='{$this->data_id}' type='text' id='qty-{$this->data_id}' class='qty form-control text-center ' value='{$this->default_value}'>
            <span class='input-group-btn'>
              <button class='btn btn-success btn-plus' data-id={$this->data_id} type='button' id='btn-plus-{$this->data_id}'>+</button>
            </span>
          </div><!-- /input-group -->  
        ";
        
        $template .= $this->js_script();
        echo $template;
    }
    public function js_script(){
        $view = $this->getView();
        $view->registerJs("
                function chkNumber(ele)
                {
                    var vchar = String.fromCharCode(event.keyCode);
                    if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
                    ele.onKeyPress=vchar;
                }
                if($('#qty-{$this->data_id}').val() <= 1){
                    $('#btn-sub').attr('disabled', true);
                }
                
                $('#qty-{$this->data_id}').keydown(function(event) {
                    // Allow: backspace, delete, tab, escape, enter and .
                    if ( $.inArray(event.keyCode,[46,8,9,27,13,190]) !== -1 ||
                         // Allow: Ctrl+A
                        (event.keyCode == 65 && event.ctrlKey === true) || 
                         // Allow: home, end, left, right
                        (event.keyCode >= 35 && event.keyCode <= 39)) {
                             // let it happen, don't do anything
                             return;
                    }
                    else {
                        // Ensure that it is a number and stop the keypress
                        if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                            event.preventDefault(); 
                        }   
                    }
                });
                $('#btn-plus-{$this->data_id}').on('click', function(){
                    let qty = $('#qty-{$this->data_id}');
                    let number = qty.val();
                    number++;
                    $(qty).val(number);
                    $('#btn-sub-{$this->data_id}').attr('disabled', false);
                    return false;
                });
                $('#btn-sub-{$this->data_id}').on('click', function(){
                    let qty = $('#qty-{$this->data_id}');
                    let number = qty.val();
                    number--;
                    if(number <= 1){
                        $('#btn-sub-{$this->data_id}').attr('disabled', true);
                        qty.val(1);
                    }else{
                        qty.val(number);
                    }
                    return false;
                });
        ");
        //\cpn\chanpan\assets\inputnumber\InputNumberAsset::register($view);
    }
}
