<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-header">
  <!--    <a class="navbar-brand" href="#">
	<img header="60" width="40" alt="Brand" src="../img/inc.png">
      </a>
	  -->
    </div>
			
	<div class="navbar-header">
					 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="index.php"><span class="glyphicon glyphicon-globe"></span>Chama Viva 1.2</a>
				</div>
				
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li>
							<a class="<?php echo $secretaria;?>" href="conscadastro.php?>"> <i class="glyphicon glyphicon-tasks"></i>Secretaria</a>
						</li>
						<li>
							<a class="<?php echo $tesouraria;?>" href="constesouraria.php"><i class="fa fa-fw fa-money"></i> Tesouraria</a>
						</li>
						<li>
							<a class="<?php //echo $tesouraria;?>" href="consebd.php<?php //echo $linktes;?>"><i class="glyphicon glyphicon-book"></i> EBD</a>
						</li>
					<!--	
						<li class="dropdown">
							 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown<strong class="caret"></strong></a>
							<ul class="dropdown-menu">
								<li>
									<a href="#">Action</a>
								</li>
								<li>
									<a href="#">Another action</a>
								</li>
								<li>
									<a href="#">Something else here</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="#">Separated link</a>
								</li>
								<li class="divider">
								</li>
								<li>
									<a href="#">One more separated link</a>
								</li>
							</ul>
						</li>
						-->
					</ul>
					<!--
					<form class="navbar-form navbar-left" role="search">
						<div class="form-group">
							<input type="text" class="form-control" />
						</div> <button type="submit" class="btn btn-default">Submit</button>
					</form>
					-->
					<ul class="nav navbar-nav navbar-right">
						<!--
						<li>
							<a href="#">Link</a>
						</li>
						-->
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['nome_usuario']; ?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<a href="cadusuario.php?op=A&id=<?php echo $_SESSION['id_usuario'];?>">
									<span class="fa fa-cogs"></span> Configurações</a>
								</li>
								
								<li class="divider">
								</li>
								<li>
								    <a href="../index.php"><i class="fa fa-fw fa-power-off"></i> Sair </a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
				
			</nav>