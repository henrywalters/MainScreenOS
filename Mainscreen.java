import java.sql.*;
class Mainscreen{
	
public static void main(String args[]) {
	try{
		Class.forName("com.mysql.jdbc.Driver") ;
		Connection conn = DriverManager.getConnection("jdbc:mysql://localhost:4200/MS", "root", "root123") ;
		/*String query = "insert into ServerName (SessionID, ServerPort, SessionName)" + "values (?, ?, ?)";
		PreparedStatement prep = conn.prepareStatement(query);
		prep.setInt(1, 1);
		prep.setInt(2, 4200);
		prep.setString(3, "test");
		
		prep.execute();*/
		AddSession(conn, 4200, "test");
		AddState(conn, "Testing 1 2 3");
		AddUser(conn, "Test User");
		AddUserSession(conn, 1, 1);
		conn.close();
		
		}catch(Exception e){ System.out.println(e);}  
	}  

public static void AddState(Connection conn, String cmd)
{
	try{
		String query = "insert into States (cmd)" + "values (?)";
		PreparedStatement prep = conn.prepareStatement(query);
		prep.setString(1, cmd);
		prep.execute();
	}catch(Exception e){ System.out.println(e);}
}
public static void AddUser(Connection conn, String username)
{
	try{
		String query = "insert into Users (username)" + "values (?)";
		PreparedStatement prep = conn.prepareStatement(query);
		prep.setString(1, username);
		prep.execute();
	}catch(Exception e){ System.out.println(e);}
}

public static void AddUserSession(Connection conn, int UserID, int SessionID)
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
}

public static void AddSession(Connection conn, int port, String SessionName)
{
	try{
		String query = "insert into Sessions (ServerPort, SessionName)" + "values (?, ?)";
		PreparedStatement prep = conn.prepareStatement(query);
		prep.setInt(1, port);
		prep.setString(2, SessionName);
		prep.execute();
	}catch(Exception e){ System.out.println(e);}
			
}


}