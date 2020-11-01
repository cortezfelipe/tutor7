<?php
/**
 * MatControladoEventoFormList Form List
 * @author  <your name here>
 */
class EventoForm extends TPage
{
    protected $form; // form
    
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();
        
        
        $this->form = new BootstrapFormBuilder('form_MatControladoEvento');
        $this->form->setFormTitle('Controle de Eventos');
        

        // create the form fields
        $id = new TEntry('id');
        $controlado_id = new THidden('controlado_id');
        $controlado_id->setValue(TSession::getValue(__CLASS__.'controlado_id'));
        $dataevento = new TDate('dataevento');
        $dataevento->setMask('dd/mm/yyyy');
        $dataevento->setDatabaseMask('yyyy-mm-dd');        
        $tipo_id = new TDBUniqueSearch('tipo_id', 'ORACLE', 'MatControladoEventoTipo', 'id', 'tipo', 'tipo');
        $tipo_id->setMinLength(0);// create the form actions
        
        $obs = new TText('obs');
        
        // create the button aux
        $action = new TAction(array('FormTipoEvento', 'onEdit'));
        $button = new TActionLink('', $action , 'green', null, null, 'fa:plus-circle');
        $button->class = 'btn btn-default inline-button';
        $button->popover    = 'true';
        $button->popside    = 'left';
        $button->poptitle   = 'Novo Tipo de Evento';
        $button->poptrigger = 'click';
        $button->popaction  = $action->serialize(FALSE);
        $tipo_id->after($button);

        // add the fields
        $this->form->addFields( [ new TLabel('Código') ], [ $id ] );
        $this->form->addFields( [ new TLabel('Evento') ], [ $tipo_id ]  );
        $this->form->addFields( [ new TLabel('Data Evento') ], [ $dataevento ] );
        $this->form->addFields( [ new TLabel('Observação') ], [ $obs ] );
        $this->form->addFields( [ $controlado_id ] );
        


        // set sizes
        $id->setSize('100%');
        $controlado_id->setSize('100%');
        $dataevento->setSize('100%');
        $tipo_id->setSize('100%');
        $obs->setSize('100%');



       
        /** samples
         $fieldX->addValidation( 'Field X', new TRequiredValidator ); // add validation
         $fieldX->setSize( '100%' ); // set size
         **/
        
        
        
        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        $container->add(TPanelGroup::pack('', $this->datagrid, $this->pageNavigation));
        
        parent::add($container);
    }
}