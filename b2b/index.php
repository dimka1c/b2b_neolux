<?php
@setlocale(LC_ALL, 'ru_RU.cp1251');
#@setlocale(LC_CTYPE, array("ru_RU.CP1251", "ru_SU.CP1251", "ru_RU.KOI8-r", "ru_RU", "russian", "ru_SU", "ru")); 
error_reporting(E_ERROR);
session_start();

#############################
# ������� neolux            #
#############################
# Globals
define ('KERNEL',"/home/udt/neolux.com.ua/conf/kernel.php");
define ('DBCONF',"/home/udt/neolux.com.ua/conf/dbconfig1.php");
Include (KERNEL);
include (DBCONF);
require_once 'include/mysql.class.php';
require_once 'include/parse.class.php';
$db = new db;
include_once("core.php");
include_once("function.php");
include_once("basket.php");
include_once("regis.php");
################################
# �������� ����������� 1�
$dates=date("d-m-Y");
#$xyURL = "$server/default.asp?login=$user&passwd=$pass";
#$OpenFile = fopen("$xyURL", "r");
#if (!$OpenFile) {
#   	htmlheader("������� ������������ ������� NeoLux.com.ua; � ��� ������ ������� - $dates","");
#	echo "<table width=\"100%\" height=\"1000\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" bgcolor=\"#000000\">";
#    echo "<tr><td height=\"500\" align=\"center\" valign=\"middle\"><h2>������� ������ - SHOP CLOSED</h2>��������, � ������ ������ ������� <b>������</b>. ������� ���� �����.<hr width=\"99%\"><i>������ ���� ������ � ���.</i></td></tr>\n";
#	echo "</table>";
#	echo "</body></html>";
#    exit;
#}
#}
################################
# MAIN
################################

if (isset($_REQUEST['currency_id'])) {
	if (ctype_digit($_POST['currency_id']) and strlen($_POST['currency_id'])=="1") {
	$_SESSION["neo"]["valuta"]=$_POST['currency_id'];
}
}

if (isset($_REQUEST['vievtypes'])) {
	if (ctype_digit($_POST['vievtypes']) and strlen($_POST['vievtypes'])=="1") {
	$_SESSION["neo"]["viewtype"]=$_POST['vievtypes'];
}
}


if (isset($_GET['basket'])) {
$basket=$_GET['basket'];
}elseif (isset($_GET['do'])) {
$basket=$_GET['do'];	
}

switch($basket)
        {       
        	
        		case "account":
        		doaccaunt();
        	    break;
        	     
        		case "dosend":
        		formatbasketpay($_POST['check'],$_POST['prim'],$_POST['sendata']);
        		break;
        		
        		case "create_account":
        		createaccount1cmysql($_POST['create_account'],$_POST['cvvv'],$_POST['firstname'], $_POST['lastname'], $_POST['email_address'], $_POST['company'], $_POST['street_address'], $_POST['suburb'], $_POST['postcode'], $_POST['city'], $_POST['state'], $_POST['country'], $_POST['telephone'], $_POST['fax'], $_POST['newsletter'], $_POST['login'],  $_POST['password'], $_POST['confirmation']);
        		break;
        		
				case "info":
                infotovara($code);
                break;

				case "add":
                basketadd($_POST['kodtovara'],$_POST['kolvo'],$_POST['tovara'],$_POST['chena'],$_POST['menu'],$_POST['price']);
                break;

                case "edit":
                basketedit($_POST['kodtovara'],$_POST['kolvo'],$_POST['error'],$_POST['prim']);
                break;
                
				case "change":
                basketchange($_POST['kodtovara'],$_POST['changes'],$_POST['kolvo'],$_POST['error']);
                break;
                
                case "deleteone":
                basketdeleteone($_POST['kodtovara']);
                break;

                case "dostavka":
                helpmenudostavka();
                break;

                case "garant":
                helpmenugarant();
                break;

                case "payment":
                helpmenupayment();
                break;

                case "contact":
                helpmenucontact();
                break;

                case "service":
                helpmenuservice();
                break;
                
                case "login":
                helpmenulogin();
                break;

                case "404":
                helpmenu404();
                break;

                case "403":
                helpmenu403();
                break;

                case "security":
                helpmenusecurity();
                break;
				
                case "partner":
                helpmenupartner();
                break;
                
                case "prihod":
                basketprihod($error);
                break;
                
                case "sendmail":
	            usercontact($_POST['to'],$_POST['subject'],$_POST['body'],$_POST['secimages'],$error);
	  			break;	  

  			    case "sendmailcontact":
	            usercontactsend($_POST['to'],$_POST['subject'],$_POST['body'],$_POST['secimages'],$error);
	            break;
				
	            case "sort":
	            savesortprice($_POST['url'],$_POST['sort']);
	            break;
	            
	            case "nalich":
	            savenalich($_POST['url'],$_POST['nalich']);
	            break;
	            
	            case "search":
	            searchfind($_POST['url'],$_POST['find']);
	            break;
	            
	            case "show":
	            showtovatone($_GET['id']);
	            break;
	            
	            case "validating":
	            checkautoreg($_GET['id']);
	            break;
	            
	            case "brand":
	            showbrand($_GET['id']);
	            break;	            
	            
                default:
                main($_GET['menu'],$_GET['price'],$_GET['error'],$_GET['titles'],$_GET['nalich'],$centralnoepole,$content,$keywords,$description);
                break;
        }
$db->close();
$_SESSION["neo"]["error"]="";

#################################################################################
function create_metatags ($story) {
global $config, $db;

$keyword_count = 20;
$newarr = array ();
$headers = array ();
$quotes = array( "\x27", "\x22", "\x60", "\t",'\n','\r', "\n","\r", '\\', "'",",",".","/","?","#",";",":","@","~","[","]","{",
"}","=","-","+",")","(","*","&","^","%","$","<",">","?","!", '"' );
$fastquotes = array( "\x27", "\x22", "\x60", "\t","\n","\r",'"',"'", '\r', '\n', "/", "\\");

  $story = preg_replace ("'\[hide\](.*?)\[/hide\]'si", "", $story);
  $story = preg_replace ("'\[attachment=(.*?)\]'si", "", $story);
  $story = preg_replace ("'\[page=(.*?)\](.*?)\[/page\]'si", "", $story);
  $story = str_replace( "{PAGEBREAK}", "", $story );
  $story = str_replace( "��������", "", $story );
  $story = str_replace( "�����", "", $story );
  $story = str_replace( "����������", "", $story );
  $story = str_replace( "��������", "", $story );
  $story = str_replace( "���������", "", $story );
  $story = str_replace( "������ ������ ������� � �������", "", $story );
  $story = str_replace( "����������� �� ����", "", $story );
  $story = str_replace( "�������", "", $story );
  $story = str_replace( "����������", "", $story );
  $story = str_replace( "�����", "", $story );
  $story = str_replace( "'\((.*?)\)'si", "", $story );
  
  $story = str_replace('<br />', ' ', $story );
  $story = trim(strip_tags ($story));

  if (trim($_REQUEST['descr']) != "") {
          $headers['description'] = $db->safesql(substr(strip_tags(stripslashes($_REQUEST['descr'])), 0, 190));
  } else {
        $story = str_replace($fastquotes, '', $story );

        $headers['description'] =substr($story, 0, 190);
  }

  if (trim($_REQUEST['keywords']) != "") {
          $headers['keywords'] = str_replace($fastquotes, " ", strip_tags(stripslashes($_REQUEST['keywords'])));

  } else {

        $story = str_replace($quotes, '', $story );

        $arr   = explode(" ", $story);

        foreach ($arr as $word) {
        if (strlen($word) > 4) $newarr [] = $word;
        }

        $arr   = array_count_values ($newarr);
        arsort ($arr);

        $arr = array_keys($arr);

        $total = count ($arr);

        $offset = 0;

        $arr =  array_slice ($arr, $offset, $keyword_count);

        $headers['keywords'] = implode (", ", $arr);
  }

return $headers;
}
################################################################################

################################################################################
function formatbasketpay($check,$prim,$sendata){
global $config, $db, $server;
$err="";
if ($_SESSION["neo"]["url"]!="serverneolux") {	header("Location: /"); exit; }
if (!$_SESSION["neo"]["exit"]) {	header("Location: /"); exit; }
if ($sendata=="" and $sendata!="��������� �����") {	header("Location: /"); exit; }
else {
$logins=$_SESSION["neo"]["uid"];

$result=$db->query("select id from basket where login='$logins';");
$kzakaz=$db->num_rows($result);
$db->free($result);
if ($kzakaz>0) {

$fpp="$server/basket_neolux.asp?login=$logins";
$fp=fopen($fpp,"r");
if ($fp) { 

	while (!feof($fp)) {
    $contents.= fread($fp, 8192);
    }

    if ($contents=="1") {
    
    	# ������ � ���� � ������� � �������	
    	$result=$db->query("delete from basket where login='$logins';");
		$db->free($result);

	}else {
		# ����� ������
	$err="��������� ������. ���������� �������� ����� �����.";	
    }

fclose($fp);
} else { $err="<p><b>��� ����� � ��������!</b></p>"; }	

if ($err=="") {

$titles="���������� ������.";
$centralnoepole="context/oksendbasket.php";
$keywords="";
$description="";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);		
exit;	
}
else {
$sss="<div class=\"alertbox\">$err</div>";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$sss,$keywords,$description);
exit;	
}

} else { 

$sss="<div class=\"alertbox\">������, ���-�� �� ������� �� ��. ���� ��� �� ��� �������� ��� �� ����.</div>";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$sss,$keywords,$description);
exit;
}
}	
}
################################################################################

################################################################################
function searchfind($url,$find){

	$host  = $_SERVER['HTTP_HOST'];
    if($_GET['basket']!="search") { header("Location: http://$host/?"); exit; }
    if($_GET['url']) { header("Location: http://$host/?url"); exit; }
	if(!$_POST['find']) { header("Location: http://$host/?"); exit; }
	
	$find=trim($find);
	if (strlen($find)> 25 ) { substr($find,0,25); }
	if (strlen($find)< 3 ) { $_SESSION["neo"]["error"]="<span class=\"errorText\">��� ������ �� ����� �� ������ ������������ �� ����� 3 ��������</span>";  header("Location: http://$host/?"); exit;}
	$find=addslashes($find);
	$_SESSION["neo"]["find"]=$find;

    list($tr1,$tr2) = explode("::", $url);
    if (!ctype_digit($tr1) or !ctype_digit($tr2)) { $tr1=50; $tr2=50; }
    if ($tr1 != 0 && $tr2 !=0 ) {
    header("Location: http://$host/index.php?menu=$tr1&price=$tr2&find=1");
    } else {
    header("Location: http://$host/");	
    }



}
################################################################################
function savesortprice($url,$sort){

	$host  = $_SERVER['HTTP_HOST'];
	if($_GET['basket']!="sort") { header("Location: http://$host/?"); exit; }
	if($_GET['url']) { header("Location: http://$host/?url"); exit; }
	if ($sort=="+") $_SESSION["neo"]["sort"]="pluse";
	if ($sort=="-") $_SESSION["neo"]["sort"]="minus";
    list($tr1,$tr2,$tr3) = explode("::", $url);
    if (!ctype_digit($tr1) or !ctype_digit($tr2) or !ctype_digit($tr3)) { $tr1=50; $tr2=50; }
    if ($tr3!="") {$tr3html="&parentid=$tr3";}
    if ($tr1 != 0 && $tr2 !=0 ) {
    header("Location: http://$host/index.php?menu=$tr1&price=$tr2$tr3html");
    } else {
    header("Location: http://$host/");	
    }

}
##############################################################################
function savenalich($url,$nalich){
	
	$host  = $_SERVER['HTTP_HOST'];
	if($_GET['basket']!="nalich") { header("Location: http://$host/?"); exit; }
	if($_GET['url']) { header("Location: http://$host/?url"); exit; }


	if ($nalich=="yes" ) $_SESSION["neo"]["nalich"]=$nalich; 
	if ($nalich=="no" ) $_SESSION["neo"]["nalich"]=$nalich; 
	
	list($tr1,$tr2,$tr3,$tr4) = explode("::", $url);
    
	if (!ctype_digit($tr1) or !ctype_digit($tr2)) { $tr1=50; $tr2=50; }
    
	if ($tr1 != 0 && $tr2 !=0 && $tr4=="" ) {
    
		if ($tr3!="") {$tr3="&parentid=$tr3";}
    
		header("Location: http://$host/index.php?menu=$tr1&price=$tr2$tr3");
    
    } elseif ($tr4!=""){
    header("Location: http://$host/index.php?$tr4$tr3");
    }
    else {
    header("Location: http://$host/");	
    }

}
################################################################################
function usercontactsend($to,$subject,$body,$secimages,$error) {

$secimages=trim($secimages);
$code = strval($_SESSION["protectioncode"]);
$_SESSION["protectioncode"]="";

if ($secimages!=$code)  { $error.="�� ������ ��� �������������<br>";   }
if (!eregi("(['_a-z0-9-]+(\\.['_a-z0-9-]+)*@[a-z0-9-]+(\\.[a-z0-9-]+)*\\.(([a-z]{2,3})|(aero|coop|info|museum|name)))",$to)) { $error.="�� ������ ����� $to<br>";  }
if ($subject == "") {$error.="���� ������ �� ���������<br/>"; }
if ($body == "") {$error.="����� ������ �� ��������<br/>"; }
if (strlen($subject) <= "3") {$error.="���� ������ �� ����� ���� ����� ��������.<br/>";}

if ($error!="")
 {
usercontact($to,$subject,$body,"","<font color=red>$error</font>");
exit;
 }

 # �������� ������

 $ipshka=$_SERVER['REMOTE_ADDR'];
 $logins=$_SESSION["neo"]["uid"];
 $body.=  "\n��������� ����������: IP: $ipshka\n �����: $logins\n";
 $fromaddress="$to";
 $toz="admin@admin.com";
 $eol="\r\n";
 # Common Headers
  $headers .= 'From: Site <'.$fromaddress.'>'.$eol;
  $headers .= 'Return-Path: '.$fromaddress.''.$eol;    // these two to set reply address
  $headers .= "Message-ID: <".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol;
  $headers .= "X-Mailer: PHP v".phpversion().$eol;          // These two to help avoid spam-filters
  $headers .= "Content-Type: text/plain; charset=windows-1251".$eol;
  $headers .= "To: Dima <admin@admin.com>\r\n";
  $headers .= "CC: Slava <admin1@admin.com>\r\n";
  

$titles="�������� ������";
 
 if (mail($toz, $subject, $body, $headers)) {
    $centralnoepole="context/mailok.php";
    } else {
	$error = "<font color=red>���� ������ �� �������, ����� 10 ��� ���������� ��� ��� ���������.</font>";  }
	$keywords="";
	$description="";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);

}

################################################################################
function usercontact($to, $subject, $body,$secimages, $error) {
$_SESSION["protectioncode"] = strval(rand(1000, 9999));
$titles="��������� ������";
if ($error!="") { $error = "<strong>$error</strong><br/>";}
$centralnoepole="context/sendmail.php";
$keywords="";
$description="";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);
}
#########################################################
function helpmenusecurity() {
$titles="�������������";
$centralnoepole="context/helpmenusecurity.php";
$keywords="";
$description="";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);	
}
#########################################################
function helpmenupartner() {
$titles="����� ��������";
$centralnoepole="context/helpmenupartner.php";
$keywords="�������, ������� �� ��������, ������� �� ������, ������� �������, ���� ��������� �������";
$description="���� ����� ��������� �� ��������� �������� �������";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);	
}

#########################################################
function helpmenu404() {
$titles="������������� �������� �� �������";
$centralnoepole="context/helpmenu404.php";
$keywords="";
$description="";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);	
}
#########################################################
function helpmenu403() {
$titles="���������� ����������";
$centralnoepole="context/helpmenu403.php";
$keywords="";
$description="";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);	
}
#########################################################
function helpmenuservice() {
$titles="������";
$centralnoepole="context/service.php";
$keywords="";
$description="";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);	
}
#########################################################
function helpmenulogin() {
$titles="���������� ����������";
$centralnoepole="context/helpmenulogin.php";
$keywords="";
$description="";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);	
}
#########################################################
function helpmenucontact() {
$titles="���������� ����������";
$centralnoepole="context/helpmenucontact.php";
$keywords="��������� ���������, ����� �����";
$description="�������� �����";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);	
}
#########################################################
function helpmenupayment() {
$titles="������ ������ � ��������";
$centralnoepole="context/helpmenupayment.php";
$keywords="������ ������ � ��������, �������� ������, ������ ������, ������� ������ ������, ������ ���� � ��������, pay, visa, mastercard, privat24";
$description="������ ������ � ��������";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);	
}
#########################################################
function helpmenugarant() {

$titles="������� � ��������";
$centralnoepole="context/helpmenugarant.php";
$keywords="�������, ��������, ������� ��������";
$description="������� � ��������. �������� ��������.";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);	
	
}
#########################################################
function helpmenudostavka() {
$titles="�������� ������";
$centralnoepole= "context/helpmenudostavka.php";
$keywords="�������� ������, ��������� � ����� �������������, ��������, ������ ��������, ������,���������� ������ ��� ��� ����� ������� ��� ��� ���������� �������";
$description="�� �������� ����� ��� � ����. �������� ������";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);	
	
}
#########################################################
function main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description) {
Global $user,$pass,$db,$basket;
$contact="";
$logins=$_SESSION["neo"]["uid"];

//if ($logins != "annonimus") { 
//   $user=$logins;
//   $pass=$_SESSION["neo"]["gid"];
//   }

if ($titles=="") { $titles="NeoLux.com.ua";}
$dates=date("d-m-Y");
$widthleft="200";

$parse = new ParseFilter(Array(), Array(), 1, 1);
$trs = $parse->process($gentext);
$metatags = create_metatags ($trs);
$description=$metatags['description']; 
$keywords=$metatags['keywords'];

if($keywords=="") { $keywords="����������, ���������, ������������, ����� ������������, �������������, �������, ���������, ����������, �������, �������, TFT, �����, ���������, Intel, AMD, ����� ������������, ����, ������� ������������, ��������� ���������, ���������, ��������� ����������, ��������������, ����, ����, �����, ��������, �������� ������������, �����������,
��������, ���, ��������"; }
if($description=="") {$description="������ ������������ ���������� � ���������������. ���� �� ������������ ����������, ���� ������ �������������� ������������ ����������.  �������. �����.";}

$headers="\n<meta name=\"keywords\" content=\"$keywords\" />\n<meta name=\"description\" content=\"$description\" />\n";

htmlheader("$titles - ������� ������������ �������; � ��� ������ ������� - $dates",$headers);
//basketjava();

$result=$db->query("SELECT t.id FROM tovar t where t.tovar_ostatok>0;");
$count=$db->num_rows($result);
$db->free($result);
$result=$db->query("SELECT t.id FROM tovar t where id_transit='1';");
$countprihod=$db->num_rows($result);
$db->free($result);

#$result=$db->query("select ratio from kurs where id_valuta='4';");
#list($grivhya) = $db->get_array($result);
#$db->free($result);

#$result=$db->query("select ratio from kurs where id_valuta='2';");
#list($grivhyabez) = $db->get_array($result);
#$db->free($result);

#$result=$db->query("select ratio,currency from kurs where id_valuta='{$_SESSION["neo"]["valuta"]}';");
#list ($ratio,$textrario) = $db->get_array($result);

$result=$db->query("select id,title,small,data from news where active='1' order by id desc limit 0,3;");
$blocknews="";
while ($r=$db->get_array($result)){
$blocknews.="<div class=\"blog-top-title\">{$r['title']}</div><div class=\"newsitem-content\">{$r['small']}</div>
<div class=\"blog-top-postedby\">����: {$r['data']}</div>";

}
$db->free($result);



echo <<<HTML
<div id="wrapper-prop">
	<div id="wrapper-main">
		<div id="wrapper">

		<!-- Start of Header -->

<div id="header">
	<div id="header-right">
		<div id="header-left">

			<!-- Start of Logo, Navigation -->
			<div id="header-logo"><a href="http://neolux.com.ua" title=""><span>neolux.com.ua</span></a></div>
			<div id="header-content">
				<div id="header-banner">
					<h3>8-(056)-7444-970</h3> (��-��: 09:00-19:00)
				</div>
				<div id="header-nav">
				<dl id="header-nav-tabs-small">

						<dd id="active"><a href="index.php"><span>�������</span></a></dd>
						<dd><a href="index.php?basket=about"><span>� ���</span></a></dd>
						<dd><a href="index.php?basket=price"><span>�����-����</span></a></dd>

						<dd><a href="index.php?basket=sendmail"><span>�������� �����</span></a></dd>
						<dd><a href="index.php?basket=dostavka"><span>�������� ������</span></a></dd>
						<dd><a href="index.php?basket=garant"><span>������� � ��������</span></a></dd>
						<dd><a href="index.php?basket=service"><span>������</span></a></dd>
HTML;
if (!$_SESSION["neo"]["exit"]) { 
echo "<dd><a href=\"ajax.php?do=login\" onclick=\"Modalbox.show(this.href, {title: this.title, width: 600}); return false;\"><span>���� ��� ��������</span></a></dd> 
<dd><a href=\"./ajax.php?do=registration\" onclick=\"Modalbox.show(this.href, {title: this.title, width: 600 }); return false;\" ><span>�����������</span></a></dd>";

}else { echo '<dd><a href="index.php?do=account"><span>�������</span></a></dd><dd><a href="?act=logout"><span>�����</span></a></dd>'; }

echo <<<HTML
					</dl>
				</div>
				<div class="clear"></div>
			</div>

			<!-- End of Logo, Navigation and Banner -->

		</div>
	</div>
</div>
<!-- End of Header -->

		
HTML;



//	    $show=basketshowmain();
//        echo showkorzina($show);


//if($_SESSION['neo']['exit']) { 	print "��� ������: {$_SESSION['neo']['balans']}."; }
//$select="<form name=\"currency\" method=\"post\">";
//$select.="<select name=\"currency_id\" size=\"1\" onchange=\"window.document.currency.submit();\">";
//$result=$db->query("select ratio,currency,id_valuta from kurs;");
//while (list($ratio,$textrario,$idvaluta) = $db->get_array($result)) {
//
//	if ($_SESSION["neo"]["valuta"]=="$idvaluta") { $select.="<option value=\"$idvaluta\" selected>$textrario</option>"; }
//else { $select.="<option value=\"$idvaluta\">$textrario</option>";	}
//	
//}
//$select.="</select></form>";
$t=date("d.m.Y");
$radio="<form name=\"currency\" method=\"post\">";
$radio.="����� ����� �� $t: ";
$result=$db->query("select ratio,currency,id_valuta,text from kurs where id_valuta<>'3';");
while (list($ratio,$textrario,$idvaluta,$tttt) = $db->get_array($result)) {

if ($_SESSION["neo"]["valuta"]=="$idvaluta") { $radio.="<input type=\"radio\" name=\"currency_id\" value=\"$idvaluta\" checked=\"true\" onclick=\"this.form.currency_id.value='$idvaluta';this.form.submit()\" /> $tttt=$ratio "; $tecvaluta=$tttt; }
else { $radio.="<input type=\"radio\" name=\"currency_id\" value=\"$idvaluta\" onclick=\"this.form.currency_id.value='$idvaluta';this.form.submit()\" /> $tttt=$ratio "; }
}	
$radio.="</form>";

if($_SESSION["neo"]["exit"]) {

	$imaya=$_SESSION["neo"]["name"];
	$bal=$_SESSION["neo"]["balans"];
	$classuser=$_SESSION["neo"]["class"];
	$stexf="$imaya, ��� ������ $bal $tecvaluta.";
}
$show=basketshowmain();
$showbasketstext=showkorzina($show);
// // 


$error=$_SESSION["neo"]["error"];



print <<<HTML_ENTITIES

			<!-- Start of Main Sides -->
			<div id="main-right">
				<div id="main-left">
					<div id="main">

					<!-- Start of Content -->
						<div class="box1alt ">
							<div id="memberbar">
	<div id="memberbar-right">
		<div id="memberbar-left">
			<span style="white-space:nowrap;float:right;">

			</span>

			<span style="white-space:nowrap;">

					&nbsp;<b>����������</b> $stexf

			</span>
			<div class="clear"></div>

		</div>
	</div>
							</div>
	
<div id="breadcrumb">$showbasketstext <div style="color:red; float:center;">$error</div></div>
							<div class="clear"></div>
						</div>
						<div class="box2">
<div class="cat-top">
	<div class="cat-top-right">
		<div class="cat-top-left" align="center">
			<span style="white-space:nowrap;"><span style="padding-right: 30px">
			</span>$radio</span>

		</div>

	</div>
</div>

<table class="tborder" cellpadding="0" cellspacing="1" border="0" width="100%">
  <tr>
	<!-- Left Column -->

     <td width="220" valign="top" bgcolor="#F0F5FA">

		<table width="220" cellspacing="0" cellpadding="0">
		<!-- Catalog -->
		<tr>
			<td>
				<table class="coalition">
					<tr><td class="thead">�������</td></tr>
					<tr><td class="content"><!-- class="category_navigation_tree" -->
                    <table  width="100%">
						<tr><!-- class="main_category" -->
							<td>

HTML_ENTITIES;



if ($nalich!="1") $nalich="";
#echo menuleft("1",$menu,$nalich);
$menuss=menuleftnew("1",$menu,$nalich);
print $menuss;
print <<<HTML
							</td>
						</tr>
					</table>
					</td></tr>
				</table>
			</td>
		</tr>
		<!-- /Catalog -->
				<!-- News -->
		<tr>
			<td>
				<table class="coalition">

					<tr><td class="thead">�������</td></tr>
					<tr><td class="content">$blocknews
			        
					
					</td>
					</tr>
				</table>
			</td>
		</tr>		
		<!-- /News -->
        <tr>
			<td>

				<table class="coalition">
					<tr><td class="thead">�������������</td></tr>
					<tr><td class="content">
						<table width="100%" cellspacing="0" cellpadding="0">
 							<tr>
  							<td>
								����� ������� �� ������ - $count ��.<br />
								<a href="index.php?basket=prihod">����� ������� $countprihod ��.</a>
							  </td>
							  </tr>
  						</table>
					</td>
        			</tr>
				</table>
			</td>
		</tr>
        <!-- Currency Rate -->
        <tr>
			<td>
				<table class="coalition">
					<tr><td class="thead">�������</td></tr>
					<tr><td class="content"> 
     <!-- I.UA counter --><a href="http://www.i.ua/" target="_blank" onclick="this.href='http://i.ua/r.php?42039';" title="Rated by I.UA">
<script type="text/javascript" language="javascript"><!--
iS='<img src="http://r.i.ua/s?u42039&p65&n'+Math.random();
iD=document;iD.cookie="iua=1";if(iD.cookie)iS+='&c1';
iS+='&d'+(screen.colorDepth?screen.colorDepth:screen.pixelDepth)
+"&w"+screen.width+'&h'+screen.height
iT=iD.referrer.slice(7);iH=window.location.href.slice(7);
((iI=iT.indexOf('/'))!=-1)?(iT=iT.substring(0,iI)):(iI=iT.length);
if(iT!=iH.substring(0,iI))iS+='&f'+escape(iD.referrer.slice(7))
iS+='&r'+escape(iH);
iD.write(iS+'" border="0" width="88" height="31" />');
//--></script></a><!-- End of I.UA counter -->
					
					</td></tr>
				</table>
			</td>
        </tr>
        <!--/Currency Rate -->
        <!-- Left block
        <tr>
			<td>
				<table class="coalition">
					<tr><td class="thead"></td></tr>
					<tr><td class="content"></td></tr>
				</table>
			</td>
        </tr>
        Left block -->
		</table>
	</td>

	<!-- /Left Column -->
	<!-- Center Column -->

    <td valign="top" style="background-color: white">
		<table width="100%" cellspacing="0" cellpadding="0">
        <tr>
          <td class="advertisement"><center>
HTML;
          
        
if ($_GET['find']!="1") { $_SESSION["neo"]["find"]="";}

if(isset($price)) {
echo  "$contact ";
echo $text;
$show=showlistpricenew($user,$pass,$price,$menu,$nalich,$page,$sort);
echo $show;
}else {  


	if($centralnoepole=="") {
		if (!$_GET['basket'] and !$_GET['do']) {
		
		echo showlistpricenew($user,$pass,$price,$menu,$nalich,$page,$sort);
		
		}
	} else { 
		
		include($centralnoepole);

	}


}

if ($content != "") { echo "$content"; }

echo <<<HTML


          
          </center></td> 
          
                  </tr>
        <tr>
          <td>
<br />
<br />
          </td>
        </tr>

		</table>
	</td>

	<!-- Center Column -->


HTML;



//echo <<<HTMLL
//
//	<!-- Right Column -->
//
//    <td valign="top" width="220" bgcolor="#F0F5FA">
//    	<table width="220" cellspacing="0" cellpadding="0">
//
//      </table>
//	</td>
//
//	<!-- /Right Column -->

$brand=$db->query("SELECT name,id_brand from brand;");
if ($db->num_rows($brand)!="0") {
	while($row = $db->get_array($brand)){

		$brandhtml.="<a href=\"index.php?brand={$row['name']}\">{$row['name']}</a> ";
		
  }
} else {$brandhtml="��� ������.";}

echo <<<HTMLL
	
  </tr>
</table>

<table cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td class="thead"><center><font color=white><a class=lightstandard href="index.php">�������</a>
            &middot; <a class=lightstandard href="index.php?basket=edit">�������</a>
            &middot; 

            </font></center></td>
  </tr>
	<tr>
		<td>
		<center>

			<div class="allBrands">

				$brandhtml
			</div>
		</center>
		</td>
	</tr>
</table>
						</div>
					<!-- End of Content -->

					</div>
				</div>

			</div>
			<!-- End of Main Sides -->



HTMLL;

echo' ';




htmlfooter();
$_SESSION["neo"]["error"]="";
exit;
}
###############################################################
function showkorzina($s) {

$text="";	   
$text.="<div id=\"updatebasket\">$s</div>";

return $text;
}
#########################################################
function htmlheader($title,$dopoln){
	
print <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	<!-- JavaScript  -->
	<script type="text/javascript" src="includes/jquery-1.2.6.pack.js"></script>
	<script type="text/javascript" src="includes/prototype.js"></script>
	<script type="text/javascript" src="includes/scriptaculous.js?load=effects"></script>
	<script type="text/javascript" src="includes/modalbox.js"></script>
	<!-- JavaScript -->	
	<!-- <link rel="stylesheet" type="text/css" href="style0.css" /> -->
	<script language=JavaScript>
			if (screen.width <= '1024') {document.write ('<LINK href="style1.css" rel="stylesheet" type="text/css">');
				}    
				else {if (screen.width > '1024') {document.write ('<LINK href="style0.css" rel="stylesheet" type="text/css">'); }                 }
	</script>
	<link rel="stylesheet" href="includes/modalbox.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="dtree.css" type="text/css" />
	<script type="text/javascript" src="dtree.js"></script>
	<script type="text/javascript" src="lightbox.js"></script>
	<link rel="stylesheet" href="lightbox.css" type="text/css" />


	
HTML;
print $dopoln;
print "<title>$title</title>";
print <<<HTML
</head>
<body>
HTML;
}
#########################################################
function htmlfooter(){
?>


			<!-- Start of Footer -->
<div id="footer">
	<div id="footer-right">
		<div id="footer-left">

			<div style="float:right;text-align:right;width:auto;">
				<br />

				�������� ������� <a href="http://neolux.com.ua/"><b>NEOLUX</b></a><br />
				Copyright � 2009 <a href="index.php?basket=sendmail?basket=sendmail">�������� �����</a> &middot; 
				<a href="index.php?basket=contact">��������</a>

			</div>

		</div>
	</div>

</div>
		</div>
	</div>
</div>

<!-- End of Footer -->


</body>
</html>

<!-- footer //-->

<!-- footer_eof //-->

<?php
echo "<!-- Copy -->";

}


###################################################

################################
function basketjava(){

?>

<script type="text/javascript">
//<![CDATA[


function infos(sdt)
{
  window.open('index.php?basket=info&code='+ sdt, 'window', 'width=700,height=500,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes');
}
function ims(sdt)
{
  window.open('i.php?fimages='+ sdt, 'window', 'width=700,height=500,toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes');
}
//]]>

</script>
<?php
}
#################################################################
function infotovara($code) {
Global $user,$pass,$server,$patch;

htmlheader("����������",$dopoln);
$ipshka=$_SERVER['REMOTE_ADDR'];

if (is_file("i/$code.jpg")) echo "<center><img src=i/$code.jpg border=0></center><br><hr>";
elseif (is_file("i/$code.gif")) echo "<center><img src=i/$code.gif border=0></center><br><hr>";
elseif (is_file("i/$code.JPG")) echo "<center><img src=i/$code.JPG border=0></center><br><hr>";
elseif (is_file("i/$code.jpeg")) echo "<center><img src=i/$code.jpeg border=0></center><br><hr>";
else { echo "\n"; }

$fpp="$server/info.asp?login=$user&passwd=$pass&code=$code";
#echo "$fpp";
$fp=fopen($fpp,"r");
 if (!$fp) { echo "<p><b>��� ����� � ��������!</b></p>"; exit;}

while (!feof ($fp)) {
    $line = fgets ($fp);
    /* This only works if the title and its tags are on one line */
	/* ������ ����������� ������ � */
    #if (eregi (".*<!-- (.*) -->", $line, $out)) {
    #    $securitymenu = $out[1];
    #}
    echo $line."<br>";
}
fclose($fp);

htmlfooter();
};
#################################################################
function infotovaramin($code){
Global $user,$pass,$server,$patch;

$ipshka=$_SERVER['REMOTE_ADDR'];
$fpp="$server/info.asp?login=$user&passwd=$pass&code=$code";
$fp=fopen($fpp,"r");
 if (!$fp) { echo "<p><b>��� ����� � ��������!</b></p>"; exit;}

 while (!feof($fp)) {
  $contents .= fread($fp, 8192);
}


fclose($fp);

return $contents;
}

################################################################
####################################################################################
function defaultmainviw(){
# 101655 1517 11210
	
	
	
}
####################################################################################
function basketprihod($error) {
Global $db;
# ���-�� ������ �� ��������
$con=30;

$page=$_GET['page'];

if(isset($page) == "") $page=1;
if(isset($_POST['page'])) { header("Location: http://$host"); exit; }

$data=$_GET['data'];
if($data!="" && !ereg("[0-9]{4}-[0-9]{2}-[0-9]{2}",$data)) { header("Location: http://$host"); exit;}
if ($data!="") { $datasql=" WHERE data='$data'"; }


$titles="������ ������";
$content="";

$result=$db->query("SELECT count(*) as cont FROM tovar  where id_transit='1' ORDER BY id_data_transit ASC;");
$contovar=$db->get_row($result);
$ss=ceil($contovar['cont']/$con);
$stopcon=$page*$con;
$startcon=$stopcon-$con;

if ($page > $ss) {$page=$ss; }
if (!ctype_digit($page)) { $page="1"; }

if ($ss > "0") { $content.= "<div align=right>��������: $page �� $ss.</div><br>"; }

$content.="<span class=ch2>����� ����������� �� �����</span><br><br>";
 
$content.='<table align="center" cellpadding="2" cellspacing="1" width="100%" border="0">';
$content.='';
$content.="<tr class=headerInfo><td class=headerInfo>�</td><td class=headerInfo>����</td><td class=headerInfo>������������</td></tr>";
$result = $db->query("SELECT id,id_data_transit,name_tovar as name, codetovar as idtovar FROM tovar  where id_transit='1' ORDER BY id_data_transit DESC LIMIT $startcon, $con");
if($db->num_rows($result) != 0) {

	while($row = $db->get_array($result)){
		
	$content.="<tr><td align=center>{$row['id']}</td><td align=center>{$row['id_data_transit']}</td><td align=left><a href=\"?basket=show&id={$row['idtovar']}\" alt=\"{$row['name']}\" title=\"{$row['name']}\">{$row['name']}</a></td></tr>";
		
	}
	
}else {
	
	$content.="<tr><td align=center><B>����� ������� ���</B></td></tr>";	
	
}




$content.='</table>';
$content.="<br>";
if ($ss > 0) {
$content.= "��������: "; 
$q=1;
while ($q <= $ss)
{ 
	
	if ($page == $q) { $content.= " [<B>$q</B>] "; }
	else {
	$content.= " [<a href=\"?basket=prihod&page=$q\">$q</a>] ";
	}
	$q++;
}

$q--;
if ($q == $page && $q!="1") {
$next=$page-1;	
$content.= " <a href=\"?basket=search&page=$next\"><< ����������</a> "; 
} 

if ($q != $page && $q!="1")  {
$next=$page+1;	
$content.= " <a href=\"?basket=search&page=$next\">��������� >></a> "; 
}	
}
$content.="";
$keywords="";
$description="";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);

}
##############################################################################

##############################################################################
function menuleft($kat,$podkat,$nalich){
Global $db;

$text="";

if ($nalich != "") {$nal="&nalich=$nalich"; }



#SELECT codetovar as kodmenu, name_tovar as name, count FROM menu where active='1' ORDER BY `menu`.`id_poradok` ASC;
$result = $db->query("SELECT name_menu as name,id_menu as kodmenu FROM main_menu ORDER BY id ASC;");
while($row = $db->get_array($result)){

$text.="<tr><td height=\"17\">";
$text.= "<img src=\"images/m17.gif\" align=\"absmiddle\" height=\"5\" width=\"4\"> &nbsp;";

if ($row['kodmenu']==$podkat) {
$text.= "<b><a class=\"ml3\" href=\"index.php?menu=".$row['kodmenu']."&amp;price=".$row['kodmenu']."$nal\">".$row['name']."</a><b>";
}else{
$text.= "<a class=\"ml3\" href=\"index.php?menu=".$row['kodmenu']."&amp;price=".$row['kodmenu']."$nal\">".$row['name']."</a>";
}
$text.= "</td></tr>";
$text.= "<tr><td bgcolor=\"#f0f0f0\" height=\"1\"></td></tr>";

# ����� �������
if ($podkat!="" && $podkat==$row['kodmenu']) {

$result2 = $db->query("SELECT name_tovar as name, codetovar as kodmenu, idtovar FROM menu where main_menu_id='{$podkat}' ORDER BY id_poradok ASC;");
while($row2 = $db->get_array($result2)){
	
$text.= "<tr><td height=\"17\">";
$text.= "&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;";

$price=$_GET['price'];

if ($row2['kodpodmenu']==$price) { 
$text.= "<b><a class=\"ml3\" href=\"index.php?menu=$podkat&amp;price=".$row2['idtovar']."$nal\">".$row2['name']."</a></b></td></tr>";
} else {
$text.= "<a class=\"ml3\" href=\"index.php?menu=$podkat&amp;price=".$row2['idtovar']."$nal\">".$row2['name']."</a></td></tr>";	
}

$text.= "<tr><td bgcolor=\"#f0f0f0\" height=\"1\"></td></tr>";
}	
$db->free($result2);	
	
} // end if

   }

$db->free($result);
	
return $text;	
}


###################################################################
////////////////////////////////////////////
function checkautoreg($id) {
Global $db,$server;	
$errorq=0;
if (isset($id) and $id!="") {

	
$user_arr = explode ("||", base64_decode(rawurldecode($id)));

$regpassword = md5($user_arr[2]);

$name = trim(mysql_escape_string(htmlspecialchars($user_arr[0])));
$email = trim(mysql_escape_string($user_arr[1]));





if (md5($name.$email."6452448684636") != $user_arr[3]) { 
// ���� �� �����
$text="<font color=red>��� ����� ����� �� �����������.</font>";

}else {
// ���� �����	

$ret = $db->query("select id,status,email,pass,tel,name from autoreg where email='$email';");
if($db->num_rows($ret)=="1") {
list($retid,$status,$email,$pass,$tel,$name) = $db->get_array($ret);

if ($status=="0") {
$name=rawurlencode($name);
$xyURL = "$server/reg_user_neolux.asp?email=$email&pass=$pass&tel=$tel&name=$name";
$ret = fopen("$xyURL", "r");
if (!$ret) {  $errorq="1"; $text="�������� ��� �����������. ���������� ���� �����. <br /> ������: �� �������� ��������� ������."; }
else {
while (!feof ($ret)) {
    $line = fgets ($ret, 1024);
    $check.=$line;
}
}
fclose($ret);

if ($check=="1" )	{
$ret = $db->query("UPDATE autoreg SET status='1' where id='$retid';");
$text="���������� ��� �� ��������� ��������!<br>��� Email ����� �����������. ������ �� ������ �������������� � ��� �� �����.";
} else {
$text="<font color=red>�������� ��� �����������. ���������� ���� �����.</font> ($check)";	
}



} else {
$text="��� ������� ��� �����������.";	
	
}

} 
else { $text="<font color=red>��� ����� ����� �� �����������.</font><br />���������� � ��������������, ��� ���������� ��������.";}


}



}	

$titles="������������� ������ Email ������";
$description="";
$content="$text";
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);
	
	
}

function menuleftnew($kat,$podkat,$nalich){
Global $db;

$text=<<<HHH

<div class="dtree">
	<script type="text/javascript">
		<!--
		d = new dTree('d');
		d.add(0,-1,'<b>�������� ���������:</b>', '', '', '', 'img/sep.gif', 'img/sep.gif');

HHH;

if ($nalich != "") {$nal="&nalich=$nalich"; }


$i=1;
$result = $db->query("SELECT name_menu as name,id_menu as kodmenu,id FROM main_menu ORDER BY id ASC;");
while($row = $db->get_array($result)){

$text.= "\td.add($i,0,'{$row['name']}');\n";
$y=$i;
$result2 = $db->query("SELECT name_tovar as name, codetovar as kodmenu, idtovar FROM menu where main_menu_id='{$row['kodmenu']}' ORDER BY id_poradok ASC;");
while($row2 = $db->get_array($result2)){
$i++;	
$menuname=substr($row2['name'],0,20);
$text.= "\t\td.add($i,$y,'$menuname','index.php?menu={$row2['kodmenu']}&amp;price={$row2['kodmenu']}','{$row2['name']}');\n";

}	
$db->free($result2);	
	
$i++;
}

$text.=<<<HHHH

		document.write(d);
      
		//-->
	</script>

</div>
HHHH;
$db->free($result);
	
return $text;	
}

function showbrand($id){
Global $db;	
$id=$db->safesql($id);
if (!ctype_alnum($id)) { $id="6"; }
$result=$db->query("select name from brand where id_brand='$id';");
list ($namebrand) = $db->get_array($result);


$result=$db->query("select codetovar,name_tovar from tovar where brand='$namebrand';");
while ($row=$db->get_array($result)) {

	$brandtovar.="{$row['name_tovar']}<br />";
	
}

$titles="����� $namebrand";
$description="����� ������� �� �������";
$content="";
$content.=<<<GHFH
<table width="100%" border="0" cellspacing="1" cellpadding="0">
<tr>
	<td class="thead"><center>����� $namebrand</center></td>

</tr>
</table>
$brandtovar
GHFH;
main($menu,$price,$error,$titles,$nalich,$centralnoepole,$content,$keywords,$description);	
	
}	
?>

