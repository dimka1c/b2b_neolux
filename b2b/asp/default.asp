<%@Language=V7Script%>
<%
������� 
  Response.Buffer=1; 
//  Session.EnableSessionState=0;
  ���� (��������������(������(Request.QueryString("login").Item))=0) �  (��������������(������(Request.QueryString("passwd").Item))=0) �����
	Login1=������(Request.QueryString("login").Item);
	psw = ������(Request.QueryString("passwd").Item);
	ip1=������(Request.QueryString("pi").Item);
	�����������(Login1,psw,ip1);
	���� ��������������(���_�����������)=0 ����� //����������� ��������
%>
		<td><tr>
			<%
			Response.Write(���_�����������);
			%>
		</tr></td>
<%	���������;
  ���������;
����������
//	��������("���������� default.asp - "+������������);
������������;
Response.Flush();
Session.Abandon();
Response.End();
%> 


