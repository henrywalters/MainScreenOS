import java.sql.*;
import java.util.*;
public class FileManager {
	static Connection conn = null;
	public static void main(String args[])
	{
		try{
			Class.forName("com.mysql.jdbc.Driver") ;
			conn =  DriverManager.getConnection("jdbc:mysql://localhost:4200/MS", "root", "root123") ;
		}catch(Exception e){System.out.println(e);}
		
	}

	public static boolean cd(String folder, String parent)
	{
		
		
		if (folder == "..")
		{
			if (parent != null)
			{
				return true;
			}else{return false;}
		}
		if (parent == null)
		{
			try{
			Statement stmt = conn.createStatement();
			ResultSet rs = stmt.executeQuery("SELECT FolderID FROM Folders WHERE FolderName = '"+folder+"'");
		    return rs.next();
			}catch(Exception e){System.out.println(e);}
		}
		try{
		Statement stmt = conn.createStatement();
		ResultSet rs = stmt.executeQuery("SELECT FolderID FROM Folders WHERE FolderName = '"+folder+"' AND ParentPath = '"+parent+"'");
		return rs.next();
		}catch(Exception e){System.out.println(e);}
		return false;
	}
	
	public static ArrayList<String> ls(String path)
	{try{
		Statement stmt = conn.createStatement();
		ResultSet rs = stmt.executeQuery("SELECT FolderName FROM Folders WHERE ParentPath = '"+path+"'");
		ArrayList<String> folders = new ArrayList<String>();
		while (rs.next()) {
	    	  folders.add(rs.getString("FolderName"));
	    	}
		return folders;
	}catch(Exception e){System.out.println(e);}
	return null;
	}
	}

