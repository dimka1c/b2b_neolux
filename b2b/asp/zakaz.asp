<%@Language=V7Script%>

<%
�������

	Login1=������(Request.QueryString("login").Item);
	psw = ������(Request.QueryString("passwd").Item);
	ip1=������(Request.QueryString("pi").Item);

	�����������(Login1,psw,ip1);
	
	���� (��������������(���_�����������)=0) �����
		


	���������;

����������

������������;	
Session.Abandon();
Response.End();
%>


