<%@Language=V7Script%>

<%
	Response.CacheControl = "no-cache";
	Response.AddHeader("Pragma", "no-cache");

�������
	Login1=������(Request.QueryString("login").Item);
	psw = ������(Request.QueryString("passwd").Item);
	���� ��������������(Request.QueryString("save").Item)=0 �����
		Save_Spr=Request.QueryString("save").Item;
	���������;
	ip1=������(Request.QueryString("pi").Item);

	�����������(Login1,psw,ip1);
	
	���� (��������������(���_�����������)=0) � (��������������(Request.QueryString("save").Item)=1) �����
		���_Login="<!-- "+������������.WEB_Login;
		���_PSW=������������.WEB_psw;
		���_Mail=""; //"<!-- "+������������.�����+" -->";
		���_��������������=������������.�������.��������(�����������());
			

%>
		<%
		Response.Write(������(���_Login)+";"+������(���_PSW)+";"+������(���_Mail)+";"+������(���_��������������)+" -->");
		%> \n
<%
	���������;		
	���� �����(Save_Spr)=1 �����
		���=�������������("����������.�������");
		���.�����������(������������.���);
		���.WEB_Login=������(������(Request.QueryString("newlog").Item));
		���.WEB_psw=������(������(Request.QueryString("newpasswd").Item));
//		���.�����=������(������(Request.QueryString("mail").Item));
		���.��������();
//		��������(������������+" ���������� ��������");
	���������;

����������

������������;	
Session.Abandon();
Response.End();
%>


