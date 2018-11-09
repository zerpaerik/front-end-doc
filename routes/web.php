<?php

Route::get('/', function(){
	if(Cookie::has('token')){
		return redirect('home');
	}
	else
		return redirect('login');
});

Route::get('error', function(){
	return view('errors.401');
});

Route::get('home', 							'HomeController@index');
Route::get('login', 						'LoginController@login');
Route::post('authenticate', 				'LoginController@auth');
Route::get('logout', 						'LoginController@logOut');

/*Audit*/
Route::get('/audit', 						'AuditController@index');
/*Clients*/
Route::get('/client', 						'ClientController@index');
Route::get('/client/create', 				'ClientController@create');
Route::get('/client/edit/{id}', 			'ClientController@edit');
Route::get('/client/import',       			'ProductController@import');
/*Proveedores*/
Route::get('/supplier', 					'SupplierController@index');
Route::get('/supplier/create', 				'SupplierController@create');
Route::get('/supplier/edit/{id}', 			'SupplierController@edit');
/*Transportistas*/
Route::get('/dispatcher', 					'DispatcherController@index');
Route::get('/dispatcher/create', 			'DispatcherController@create');
Route::get('/dispatcher/edit/{id}', 		'DispatcherController@edit');
/*BranchOffice*/	
Route::get('/branch', 						'BranchController@index');
Route::get('/branch/create', 				'BranchController@create');
Route::get('/branch/edit/{id}', 			'BranchController@edit');
/*Country Tax*/	
Route::get('/countrytax', 					'CountryTaxController@index');
Route::get('/countrytax/create', 			'CountryTaxController@create');
Route::get('/countrytax/edit/{id}', 		'CountryTaxController@edit');
/*Product*/	
Route::get('/product', 						'ProductController@index');
Route::get('/product/create', 				'ProductController@create');
Route::get('/product/edit/{id}',  			'ProductController@edit');
Route::get('/product/import',       		'ProductController@import');
/*Invoice*/
Route::get('invoice/create', 				'InvoiceController@create');
Route::get('invoice/validate/{id}',			'InvoiceController@validateXML');
Route::get('invoice/createPDF/{id}',		'InvoiceController@createPDF');
Route::get('invoice', 						'InvoiceController@index');
Route::get('invoice/prefactura', 			'InvoiceController@preinvoice');
Route::get('invoice/prefactura/edit/{id}', 	'InvoiceController@edit');
Route::get('invoice/mail/{id}', 			'InvoiceController@mail');
Route::get('invoice/prefactura/mail/{id}', 	'InvoiceController@mailPDF');
Route::get('invoice/downloadXML/{id}', 	    'InvoiceController@downloadXML');
/*Permission*/
Route::resource('permission', 				'PermissionController');
/*TaxRentetion*/
Route::get('taxRetention/createPDF', 		'TaxDocumentController@createRetentionPDF');
/*User*/
Route::get('/user', 						'UserController@index');
Route::get('/user/create', 					'UserController@create');
Route::get('/user/edit/{id}',  				'UserController@edit');
/*Company*/
Route::get('/company', 						'CompanyController@index');
Route::get('/company/create', 				'CompanyController@create');
Route::get('/company/edit/{id}', 			'CompanyController@edit');
/*CompanyPlan */
Route::get('/companyplan', 					'CompanyPlanController@index');
Route::get('/companyplan/create', 			'CompanyPlanController@create');
Route::get('/companyplan/edit/{id}', 		'CompanyPlanController@edit');
/*Entity Master Data */
Route::get('/entitymasterdata', 			'EntityMasterDataController@index');
Route::get('/entitymasterdata/create', 		'EntityMasterDataController@create');
Route::get('/entitymasterdata/edit/{id}', 	'EntityMasterDataController@edit');
/*Mail Configuration */
Route::get('/mailconfiguration', 			'MailConfigurationController@index');
Route::get('/mailconfiguration/create', 	'MailConfigurationController@create');
Route::get('/mailconfiguration/edit/{id}', 	'MailConfigurationController@edit');
/*Plan */
Route::get('/plan', 						'PlanController@index');
Route::get('/plan/create', 					'PlanController@create');
Route::get('/plan/edit/{id}', 				'PlanController@edit');
/*Retention Tax*/
Route::get('/taxdocument', 				    'TaxDocumentController@index');
Route::get('/taxdocument/create',			'TaxDocumentController@create');
Route::get('/taxdocument/edit/{id}',		'TaxDocumentController@edit');
Route::get('/taxdocument/validate/{id}',	'TaxDocumentController@validateXML');
Route::get('/taxdocument/createPDF/{id}',	'TaxDocumentController@createPDF');
Route::get('/taxdocument/mail/{id}', 		'TaxDocumentController@mail');
Route::get('/taxdocument/downloadXML/{id}', 'TaxDocumentController@downloadXML');
/*Credit Notes*/
Route::get('/creditnote', 				    'CreditNoteController@index');
Route::get('/creditnote/create',			'CreditNoteController@create');
Route::get('/creditnote/edit/{id}',			'CreditNoteController@edit');
Route::get('/creditnote/validate/{id}',		'CreditNoteController@validateXML');
Route::get('/creditnote/createPDF/{id}',	'CreditNoteController@createPDF');
Route::get('/creditnote/mail/{id}', 		'CreditNoteController@mail');
Route::get('/creditnote/downloadXML/{id}', 	'CreditNoteController@downloadXML');
/*Debit Notes*/
Route::get('/debitnote', 				    'DebitNoteController@index');
Route::get('/debitnote/create',				'DebitNoteController@create');
Route::get('/debitnote/edit/{id}',			'DebitNoteController@edit');
Route::get('/debitnote/validate/{id}',		'DebitNoteController@validateXML');
Route::get('/debitnote/createPDF/{id}',		'DebitNoteController@createPDF');
Route::get('/debitnote/mail/{id}', 			'DebitNoteController@mail');
Route::get('/debitnote/downloadXML/{id}', 	'DebitNoteController@downloadXML');
/*Remission Guide*/
Route::get('/remission', 				    'RemissionController@index');
Route::get('/remission/create',				'RemissionController@create');
Route::get('/remission/edit/{id}',			'RemissionController@edit');
Route::get('/remission/validate/{id}',		'RemissionController@validateXML');
Route::get('/remission/createPDF/{id}',		'RemissionController@createPDF');
Route::get('/remission/mail/{id}', 			'RemissionController@mail');
Route::get('/remission/downloadXML/{id}', 	'RemissionController@downloadXML');

