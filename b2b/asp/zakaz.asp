<%@Language=V7Script%>

<%
Попытка

	Login1=Строка(Request.QueryString("login").Item);
	psw = Строка(Request.QueryString("passwd").Item);
	ip1=Строка(Request.QueryString("pi").Item);

	Авторизация(Login1,psw,ip1);
	
	Если (ПустоеЗначение(Сбщ_Авторизация)=0) Тогда
		


	КонецЕсли;

Исключение

КонецПопытки;	
Session.Abandon();
Response.End();
%>


