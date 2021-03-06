<?php
	error_reporting(0);
	session_start();
	include("./includes/config.php");		
	include("./classes/cor.mysql.class.php");
	include("./includes/checkLogin.php");
	$db = new MySqlConnection(CONNSTRING);
	$db->open();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
<title>Avanti &raquo; Dashboard &raquo; Users</title>
<?php
	include_once("./includes/head-meta.php");
?>
<script type="text/javascript" language="javascript" src="./javascript/lead-user.js"></script>
</head>
<body>
<div id="page">
	<div id="pageContainer">
		<div id="wrapper">	
			<div id="header">
			<?php
				$pgName = "users";
				include_once("./includes/header.php");
				$curPage = $_GET["page"];
				if(($curPage == "") || ($curPage == 0))
				$curPage=1;
				$recPerpage = 25;
				$countWhereClause = "";
				$selectWhereClause = "";
				$pageParam="";
				$sqlCount = $db->query("query","select count(unique_id) as 'total' from avn_login_master");
				$recCount = $sqlCount[0]['total'];
				$noOfpage = ceil($recCount/$recPerpage);
				$limitStart = ($curPage - 1) * $recPerpage;
				$limitEnd = $recPerpage;
			?>
			</div><!-- End of header -->
			<div id="container">
				<div class="about">Users</div><div class="act"><a href="add-users.php">Add Users</a><div id="bulkAct"><a href="javascript:void(0);" id="btnDel" onclick="javascript: _deleteUserDetail(-1,<?php echo $curPage; ?>);" class="ml5">Delete</a><div id="bulkActive"><a href="javascript:void(0);" id="statusactive" onclick="javascript: _changeuserstatus(-1,this.id,<?php echo $curPage; ?>);" class="ml5">Active</a></div></div></div><!-- End of about -->
				<?php if(isset($_SESSION["resp"]) && $_SESSION["resp"] !="")
				{
				?>
					<div id="ErrMsg" style="display: block;">
						<?php
						if($_SESSION["resp"] == "err")
							echo "<span style=\"color:#00A300;\">Error while adding Lead.</span>";
						else if($_SESSION["resp"] == "succ")
							echo "User successfully added.";
						else if($_SESSION["resp"] == "sucdt")
							echo "User successfully deleted.";
						else if($_SESSION["resp"] == "up")
							echo "User edited successfully.";
						else if($_SESSION["resp"] == "invEd")
							echo "This user can't be save because this is already exit.";
						else if($_SESSION["resp"] == "invUp")
							echo "This user can't be updated because this is already exit.";
						else if($_SESSION["resp"] == "errEd")
							echo "Error while deleting User."; 
						?>
					</div>
				<?php
				}else{
				?>
				<div id="ErrMsg"></div>
				<?php
				}
				?><!-- end of ErrMsg -->
				<div id="displayUser"></div><!-- end of displayUser -->
				<div id="disableDiv"><div id="disableText"><br /><br /><img src="./images/avn-loader.gif" /><br />Loading...</div></div>
			</div><!-- end of container -->
			<?php
				include_once("./includes/sidebar.php");
				$db->close();
			?>
		</div><!-- end of wrapper -->
	</div><!-- end of pagecontainer -->
</div><!-- end of page -->
<script type="text/javascript">
	_getLeadUserTable(<?php echo $curPage; ?>,'','')
</script>
</body>
</html>
<?php
	session_destroy();
?>