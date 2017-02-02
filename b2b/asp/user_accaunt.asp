<%@Language=V7Script%>

<%
	Response.CacheControl = "no-cache";
	Response.AddHeader("Pragma", "no-cache");

Попытка
	Login1=Строка(Request.QueryString("login").Item);
	psw = Строка(Request.QueryString("passwd").Item);
	Если ПустоеЗначение(Request.QueryString("save").Item)=0 Тогда
		Save_Spr=Request.QueryString("save").Item;
	КонецЕсли;
	ip1=Строка(Request.QueryString("pi").Item);

	Авторизация(Login1,psw,ip1);
	
	Если (ПустоеЗначение(Сбщ_Авторизация)=0) И (ПустоеЗначение(Request.QueryString("save").Item)=1) Тогда
		Стр_Login="<!-- "+Пользователь.WEB_Login;
		Стр_PSW=Пользователь.WEB_psw;
		Стр_Mail=""; //"<!-- "+Пользователь.Почта+" -->";
		Стр_ГлубинаКредита=Пользователь.Глубина.Получить(ТекущаяДата());
			

%>
		<%
		Response.Write(СокрЛП(Стр_Login)+";"+СокрЛП(Стр_PSW)+";"+СокрЛП(Стр_Mail)+";"+СокрЛП(Стр_ГлубинаКредита)+" -->");
		%> \n
<%
	КонецЕсли;		
	Если Число(Save_Spr)=1 Тогда
		Спр=СоздатьОбъект("Справочник.Клиенты");
		Спр.НайтиПоКоду(Пользователь.Код);
		Спр.WEB_Login=СокрЛП(Строка(Request.QueryString("newlog").Item));
		Спр.WEB_psw=СокрЛП(Строка(Request.QueryString("newpasswd").Item));
//		Спр.Почта=СокрЛП(Строка(Request.QueryString("mail").Item));
		Спр.Записать();
//		Сообщить(Пользователь+" Сохранение Аккаунта");
	КонецЕсли;

Исключение

КонецПопытки;	
Session.Abandon();
Response.End();
%>


