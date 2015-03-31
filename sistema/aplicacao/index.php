<?php session_start();

//print_r ($_SESSION); 
//exit;
require("../include/seguranca.php");

$sql =" SELECT * FROM biblia.Palavra(); ";
//$rs = pg_query($sql);
$row = pg_fetch_array($rs = pg_query($sql));
$biblia = $row['0'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<title>Chama Viva - SisGi V 0.1</title>

<!-- Bootstrap Core CSS -->
<link href="../css/bootstrap.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="../css/sb-admin.css" rel="stylesheet">

<!-- Morris Charts CSS -->
<link href="../css/plugins/morris.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../font-awesome-4.1.0/css/font-awesome.css" rel="stylesheet" type="text/css">

</head>

<body>
<!-- Topo -->
<?php require("topo.php"); ?>

<?php 
//print_r ($_REQUEST);
	$e = $_REQUEST['erro'];
	if($e == 1){
		$erro = '
		<div class="alert alert-warning alert-dismissable">       
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>   
            <i class="fa fa-info-circle"></i>  <strong>ERRO!</strong> Você não tem acesso a essa pagina! consulte o administrador! 
        </div> 
		';
	}

	echo $erro; ?>

<!-- /Corpo do Site -->
<div id="page-wrapper">
    
    <div class="container-fluid"> 
        <form name="form" class="form-horizontal" method="post" action="<?php echo $FORM_ACTION;?>" id="form" >
    <fieldset>
        <!-- Page Heading -->       
        <div class="row">       
            <div class="col-lg-12">     
                <h1 class="page-header">     
                    Seja bem-vindo <small></small>   
                </h1>                    
                <ol class="breadcrumb">     
                    <li class="active">    
                        <i class="fa fa-cogs"></i> CHAMA VIVA - Sistema de Gestão de Igreja  - perfil: <?php echo $perfil;?>
                    </li>                        
				</ol>       
            </div> 
		</div>          
        
		<div class="row">        
            <div class="col-lg-12">      
                <div class="alert alert-info alert-dismissable">       
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>   
                    <i class="fa fa-info-circle"></i>  <strong>A Paz do Senhor Jesus <?php echo $nome_usuario;?>! </strong> 
                   <br> Versículo Bíblico da Hora:  
					<strong><p><?php echo $biblia;?></p></strong> 
                </div> 
            </div>   
        </div>  
             
        <div class="row">    
            <div class="col-lg-3 col-md-6">     
                <div class="panel panel-green disabled" >    
                    <div class="panel-heading">  
                        <div class="row" disabled>      
                            <div class="col-xs-3">     
                                <i class="fa fa-money fa-5x"></i>  
                            </div>   
                            <div class="col-xs-9 text-right">  
                                <div class="huge" disabled>TES</div>  
                                <div>Modulo de Tesourario</div>   
                            </div>            
                        </div> 
                    </div> 
                    <a class="<?php echo $tesouraria;?>" href="constesouraria.php" > 
                        <div class="panel-footer">  
                            <span class="pull-left" >Acessar</span>   
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>    
                        </div> 
                    </a>   
                </div>  
            </div>   
            <div class="col-lg-3 col-md-6"> 
                <div class="panel panel-primary">   
                    <div class="panel-heading">  
                        <div class="row">  
                            <div class="col-xs-3"> 
                                <i class="fa fa-tasks fa-5x"></i>   
                            </div>          
                            <div class="col-xs-9 text-right">     
                                <div class="huge">SEC</div>  
                                <div>Secretaria</div>    
                            </div>    
                        </div>   
                    </div>   
                    <a class="<?php echo $secretaria;?>" href="conscadastro.php"> 
                        <div class="panel-footer">      
                            <span class="pull-left">Acessar</span>    
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>      
                            <div class="clearfix"></div>  
                        </div>              
                    </a>     
                </div>      
            </div>        
            <div class="col-lg-3 col-md-6"> 
                <div class="panel panel-yellow">  
                    <div class="panel-heading">     
                        <div class="row">      
                            <div class="col-xs-3">    
                                <i class="glyphicon glyphicon-book fa-5x"></i> 
                            </div>  
                            <div class="col-xs-9 text-right">   
                                <div class="huge">EBD</div>  

                                <div>Escola Bíblica Dominical</div>     
                            </div>                 
                        </div>                
                    </div>    
                    <a href="consebd.php">      
                        <div class="panel-footer">   
                            <span class="pull-left">Acessar</span>  
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>  
                            <div class="clearfix"></div>   
                        </div>              
                    </a>            
                </div>         
            </div>  
		<!--		
            <div class="col-lg-3 col-md-6">   
                <div class="panel panel-red"> 
                    <div class="panel-heading">   
                        <div class="row">      
                            <div class="col-xs-3">     
                                <i class="fa fa-database  fa-5x"></i>     
                            </div>      
                            <div class="col-xs-9 text-right">     
                                <div class="huge">REL</div>  
                                <div>Relatorio</div>         
                            </div>           
                        </div>          
                    </div>      
                    <a href="#"> 
                        <div class="panel-footer">   
                            <span class="pull-left">Gerar Relatorio</span> 
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>   
                            <div class="clearfix"></div> 
                        </div>              
                    </a>      
                </div>       
            </div>   
				
        </div>	-->	
        <!-- /.row -->  
        <div class="row"> 
            <div class="col-lg-3 col-md-6">      
                <div class="panel panel-green">  
                    <div class="panel-heading">    
                        <div class="row">         
                            <div class="col-xs-3">    
                                <i class="fa fa-user fa-5x"></i>    
                            </div>                  
                            <div class="col-xs-9 text-right">        
                                <div class="huge">USU</div>      
                                <div>Usuário do Sistema</div>              
                            </div>        
                        </div>     
                    </div>    
                    <a class = "<?php echo $naoadm;?>"href="consusuario.php">       
                        <div class="panel-footer">  
                            <span class="pull-left">Acessar</span> 
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span> 
                            <div class="clearfix"></div>       
                        </div>           
                    </a>               
                </div>          
            </div>             
		<!--	
		   <div class="col-lg-3 col-md-6">   
                <div class="panel panel-primary">   
                    <div class="panel-heading">     
                        <div class="row">      
                            <div class="col-xs-3"> 
                                <i class="fa fa-truck  fa-5x"></i>    
                            </div>                                
                            <div class="col-xs-9 text-right">
                                <div class="huge">FOR</div>   
                                <div>Fornecedor</div>       
                            </div>                
                        </div>                
                    </div>              
                    <a href="#">        
                        <div class="panel-footer">
                            <span class="pull-left">Pesquisar Fornecedor</span>     
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>   
                            <div class="clearfix"></div>     
                        </div>                  
                    </a>                   
                </div>              
            </div>    
            <div class="col-lg-3 col-md-6">  
                <div class="panel panel-yellow">  
                    <div class="panel-heading">   
                        <div class="row">     
                            <div class="col-xs-3">   
                                <i class="fa fa-cogs  fa-5x"></i>
                            </div>                
                            <div class="col-xs-9 text-right">   
                                <div class="huge">SIS</div>  

                                <div>Sistema</div>   
                            </div>      
                        </div>       
                    </div>        
                    <a href="#">   
                        <div class="panel-footer">   
                            <span class="pull-left">Informação sobre o Sistema</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>    
                            <div class="clearfix"></div>      
                        </div>       
                    </a>             

                </div>    
              </div>  
			
                <div class="col-lg-3 col-md-6">         
                    <div class="panel panel-red">       
                        <div class="panel-heading">    
                            <div class="row">          
                                <div class="col-xs-3">              
                                    <i class="fa fa-stethoscope  fa-5x"></i>           
                                </div>               
                                <div class="col-xs-9 text-right">                      
                                    <div class="huge">SUP</div>  
                                    <div>Suporte</div>            
                                </div>                       
                            </div>         
                        </div>         
                         <a class="fancybox fancybox.iframe" href="suporte.php">   
                            <div class="panel-footer">                 
                                <span class="pull-left">Suporte Tecnico</span>                   
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>     
                                <div class="clearfix"></div>       
                            </div>             
                        </a>   
                    </div>        
                </div>
-->					
            </div>      
            <!-- /.row -->         
            <!-- /.row -->        
          
            <!-- /.container-fluid -->    
            </fieldset>
        
    </form>
        </div>  
    
        <!-- /#page-wrapper -->  
    </div>

<!-- jQuery Version 1.11.0 --> 
<script src="../js/jquery-1.11.0.js"></script> 

<!-- Bootstrap Core JavaScript --> 
<script src="../js/bootstrap.min.js"></script> 

<!-- Morris Charts JavaScript --> 
<script src="../js/plugins/morris/raphael.min.js"></script> 
<script src="../js/plugins/morris/morris.min.js"></script> 
<script src="../js/plugins/morris/morris-data.js"></script>


</body>
</html>