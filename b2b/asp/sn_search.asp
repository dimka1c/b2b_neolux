<%@Language=V7Script%>

<%
����� ���, ����;
����� �����, ���������,��������, ������, ���;
����� ������;
����� ��������;


//------------------ ����������� ���������� �������� �������
//SN - �������� ����� �������� ��������� ���������
//SN_Search - ��� �����, ������� �������� � ����� ������
������� ����������SN(SN, SN_Search, ����);

	    	SN=����(������(SN));
		��_��=����(������(SN_Search));
		�����_SN = ��������(������(SN)); //����� ���.������ � ��������� ��������
		�����_����� = ��������(������(��_��)); //����� ���.������ � ����� ������
		���� (��������������(SN)=1) ��� (�����_SN<3) �����
			������� 0;
		���������;
		
		���� �����_SN >= �����_����� �����
			�����=�����_�����;
			��� = ����(������(SN),�����);
			���� ������(��_��)=������(���) �����
				������� 1;
			����� 
				������� 0;
			���������;
		�����
			�����=�����_SN;
			��� = ����(��_��,�����);
			���� ������(SN)=������(���) �����
				������� 1;
			����� 
				������� 0;
			���������;
		���������;
		    

������������
//------------------------------

//	Response.CacheControl = "no-cache";
//	Response.AddHeader("Pragma", "no-cache");

�������

���������� = '10.10.2002'; //��������������();
��������� = �����������();


Login1=������(Request.QueryString("login").Item);
psw = ������(Request.QueryString("passwd").Item);
��������=������(Request.QueryString("sn").Item);
ip1=������(Request.QueryString("pi").Item);
�����������(Login1,psw,ip1);
���� ��������������(���_�����������)=0 �����  //����������������
//	��������(������������+" ����� S/N "+��������);			
	��� = �������������("��������.��������");
	���.����������������(����������, ���������);
	���� ���.����������������()>0 ����
		���� ���.����������=������������ �����
			������ = ���.���������������();
			������.�������������();
			���� ������.��������������() > 0 ����
				����������SN = ����������SN(������(������.��), ������(��������),������);
				���� ����������SN = 1 �����
					�������="<!-- "+������.������������+";"+������.��+";"+������.�������+";"+������.����������+";"+������.�������+" -->";
%>
					<%
					Response.Write(�������);
					%> \n
<%
				���������;
			����������;
		���������;
	����������;


���������;

����������

������������;
Session.Abandon();
Response.End();
%>