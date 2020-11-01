<?php
/**
 * FormSessionDataView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class FormTipoEvento extends TPage
{
    private $form;
    
    /**
     * Class constructor
     * Creates the page
     */
    function __construct()
    {
        parent::__construct();
        
        // create the form
        $this->form = new BootstrapFormBuilder;
        $this->form->style = 'min-width: 200px';
        $this->form->setProperty('style', 'margin:0; border:0');
        $form_id = $this->form->getId();
        
        // create the form fields
        $tipo = new TEntry('tipo');
        
        // add the fields inside the form
        $row = $this->form->addFields([new TLabel('Tipo')],  [$tipo] );
        $row->layout = ['col-sm-4', 'col-sm-8'];
        
        // define the form action 
        $btn = $this->form->addAction(_t('Save'), new TAction([$this, 'onSave']), 'fa:save');
        $btn->class = 'btn btn-sm btn-primary';
        
        TScript::create("$('#{$form_id}').closest('.popover-content').css('padding',0)");
        
        parent::add($this->form);
    }
    
    
    /**
     * Save form data into session
     */
    public static function onSave($param)
    {
       
       try
        {
                       
            
            //oculta popover
            TScript::create("$('.popover').popover('hide');");
            
            
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            //$this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
       
       
        
    }
    
    public static function onEdit($param)
    {
       
    }
}
