<%@Language=V7Script%>
<%
Попытка 
  Response.Buffer=1; 
//  Session.EnableSessionState=0;
  Если (ПустоеЗначение(Строка(Request.QueryString("login").Item))=0) И  (ПустоеЗначение(Строка(Request.QueryString("passwd").Item))=0) Тогда
	Login1=Строка(Request.QueryString("login").Item);
	psw = Строка(Request.QueryString("passwd").Item);
	ip1=Строка(Request.QueryString("pi").Item);
	Авторизация(Login1,psw,ip1);
	Если ПустоеЗначение(Сбщ_Авторизация)=0 Тогда //Авторизация пройдена
%>
		<td><tr>
			<%
			Response.Write(Сбщ_Авторизация);
			%>
		</tr></td>
<%	КонецЕсли;
  КонецЕсли;
Исключение
//	Сообщить("Исключение default.asp - "+Пользователь);
КонецПопытки;
Response.Flush();
Session.Abandon();
Response.End();
%> 


