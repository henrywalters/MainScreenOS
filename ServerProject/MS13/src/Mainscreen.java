import java.sql.*;
class Mainscreen{
	static Connection conn = null;
public static void main(String args[]) {
	try{
		Class.forName("com.mysql.jdbc.Driver") ;
		conn =  DriverManager.getConnection("jdbc:mysql://localhost:4200/MS", "root", "root123") ;
		}catch(Exception e){System.out.println(e);}
}

public static void AddState(String cmd)
{
	try{
		String query = "insert into States (cmd)" + "values (?)";
		PreparedStatement prep = conn.prepareStatement(query);
		prep.setString(1, cmd);
		prep.execute();
	}catch(Exception e){ System.out.println(e);}
}

public static void AddUser(String username)
{
	try{
		String query = "insert into Users (username)" + "values (?)";
		PreparedStatement prep = conn.prepareStatement(query);
		prep.setString(1, username);
		prep.execute();
	}catch(Exception e){ System.out.println(e);}
}

/*public static void AddUserSession(int UserID, int SessionID)
{
	try{
		if (UserID > 0 & SessionID > 0)
		{
		String query = "insert into UserSessions (UserID, SessionID)" + "values (?, ?)";
		PreparedStatement prep = conn.prepareStatement(query);
		prep.setInt(1, UserID);
		prep.setInt(2, SessionID);
		prep.execute();
		}
	}catch(Exception e){ System.out.println(e);}
}*/

/*public static void AddSession(int port, String SessionName)
{
	try{
		String query = "insert into Sessions (ServerPort, SessionName)" + "values (?, ?)";
		PreparedStatement prep = conn.prepareStatement(query);
		prep.setInt(1, port);
		prep.setString(2, SessionName);
		prep.execute();
	}catch(Exception e){ System.out.println(e);}
			
}*/

public static void AddFolder(String FolderName, String ParentPath)//, int SessionID)
{
	try{
		String query = "insert into Folders (FolderName, ParentPath)" + "values (?, ?)";
		PreparedStatement prep = conn.prepareStatement(query);
		prep.setString(1, FolderName);
		prep.setString(2, ParentPath);
//		prep.setInt(3, SessionID);
		prep.execute();
	}catch(Exception e){ System.out.println(e);}
}

public static void AddFile(String FileName, String Extension, int FolderID)//, int SessionID)
{
	try{
		String query = "insert into Files (FileName, Extension, FolderID)" + "values (?, ?, ?)";
		PreparedStatement prep = conn.prepareStatement(query);
		prep.setString(1, FileName);
		prep.setString(2, Extension);
		prep.setInt(3, FolderID);
//		prep.setInt(4, SessionID);
		prep.execute();
	}catch(Exception e){ System.out.println(e);}
}

}