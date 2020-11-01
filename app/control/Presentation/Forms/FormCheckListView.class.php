<?php
/**
 * FormCheckListView
 *
 * @version    1.0
 * @package    samples
 * @subpackage tutor
 * @author     Pablo Dall'Oglio
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class FormCheckListView extends TPage
{
    private $form;
    private $order_list;
    
    public function __construct($param)
    {
        parent::__construct();
        
        //var_dump($param);
        
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Checklist');
        
        $customer  = new TDBUniqueSearch('customer_id', 'samples', 'Customer', 'id', 'name');
        $date      = new TDate('order_date');
        $this->order_list = new TCheckList('order_list');
        
        $customer->setSize('calc(100% - 30px)');
        
        $button = TButton::create('new', [$this, 'onChange'], '', 'fa:search black');
        $button->class = 'btn btn-default inline-button';
        $button->title = _t('Find');
        $customer->after($button);
        $this->form->addField($button);
        
        
        $customer->setMinLength(1);
        $this->order_list->addColumn('id',          'Id',          'center',  '10%');
        $this->order_list->addColumn('description', 'Description', 'left',    '50%');
        $this->order_list->addColumn('sale_price',  'Price',       'left',    '40%');
        $this->order_list->setHeight(250);
        $this->order_list->makeScrollable();
         
        $this->form->addFields( [ new TLabel('Customer') ], [$customer] );
        $this->form->addFields( [ new TLabel('Date') ],     [$date] );
        
        $input_search = new TEntry('search');
        $input_search->placeholder = _t('Search');
        $input_search->setSize('100%');
        $this->order_list->enableSearch($input_search, 'id, description');
        
        $hbox = new THBox;
        $hbox->style = 'border-bottom: 1px solid gray;padding-bottom:10px';
        $hbox->add( new TLabel('Order list') );
        $hbox->add( $input_search )->style = 'float:right;width:30%;';
        
        //rotina para filtrar o TCheckList
        if (!empty($param['customer_id'])){       
        TTransaction::open('samples'); // open transaction
        $cast = (int) $param['customer_id'];
        $produtos = Product::select('id','description','sale_price')
                             ->where('id', '>', $cast)
                             ->load();
        TTransaction::close(); // close transaction
        $this->order_list->addItems( $produtos );
        }else{
        $this->order_list->addItems( Product::allInTransaction('samples') );
        }
        
        $this->form->addContent( [$hbox] );
        $this->form->addFields( [$this->order_list] );
        
        $this->form->addAction( 'Save', new TAction([$this, 'onSave']), 'fa:save green');
        
        // wrap the page content using vertical box
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);

        parent::add($vbox);
    }
    
    public function onChange($param)
    {
        
        $data = $this->form->getData();
        $this->form->setData($data);
                
    
    }
    
    /**
     * Simulates an save button
     * Show the form content
     */
    public function onSave($param)
    {
        try
        {
            $data = $this->form->getData(); // optional parameter: active record class
            
            $this->form->validate();
            echo '<pre>';
            var_dump($data);
            echo '</pre>';
            
            // put the data back to the form
            $this->form->setData($data);
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}
