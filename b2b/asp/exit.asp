<%@Language=V7Script%> 
<html>

<head>
<meta http-equiv="Content-Language" content="ru">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Завершение работы</title>
<link rel=stylesheet type="text/css" href="common.css">
<script language="Javascript" src="common.js"></script>
</head>

<body>
<table border="0" width="100%">
    <tr>
        <td class="header"><%=НаименованиеПриложения%> - Завершение работы
        </td>
    </tr>
</table>

Работа с приложением завершена.
<%Session.Abandon();%>
</body>

</html>

