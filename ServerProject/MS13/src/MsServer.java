import java.net.*;
import java.util.HashMap;
import java.util.Map;
import java.io.*;
import java.sql.*;
public class MsServer {
	static Connection conn = null;
	static String[] clients = new String[100];
	//String[] client_mice = new String[100];
	static Map<String,String> client_mice = new HashMap<String,String>();
	static Map<String,String> client_unread_commands = new HashMap<String,String>();
	static int client_count = 0;
	
    public static void main(final String[] args) {
    	HostInterface ui = new HostInterface();
    	String session_name = ui.prompt_session_name();
    	int port = ui.prompt_port();
    	
    	ServerSocket listening = null;
    	Socket socket = null;
    	
    	//String[] clients = new String[100];
    	//String[] client_mice = new String[100];
    	//Map<String,String> client_mice = new HashMap<String,String>();
    	//int client_count = 0;
    	
    	try {
    		listening = new ServerSocket(port);
    		System.out.println("Server Running on port: " + port);
    		while(true){
    			socket = listening.accept();
    			
    			BufferedReader br = new BufferedReader(new InputStreamReader(socket.getInputStream()));
    			BufferedWriter bw = new BufferedWriter(new OutputStreamWriter(socket.getOutputStream()));
    			
    			String line = "";
    			
    			while ((line = br.readLine()) != null){
    				String server_reply = "";
    				//Server Logic Here
    				//Cmd Looks something like 
    				//[cmd]:[object_id]:[user_id]:[params]
    				
    				String lines[] = line.split(":");
    				
    				
    				if (lines.length == 4)
    				{
    					String cmd = lines[0];
        				String object_id = lines[1];
        				String user_id = lines[2];
    					String params[] = lines[3].split(",");	
    				    		
					if (cmd.equals("add client")){
    					
    					if (params.length == 1 && params[0].length() > 0){
    						clients[client_count] = params[0];
    						client_count += 1;
    						client_mice.put(params[0], "0,0");
    						client_unread_commands.put(params[0], "");
    						System.out.println(client_count);
    						server_reply = "success";
    					} else if (params.length == 1 && params[0].length() == 0){
    						server_reply = "user_id can't be empty";
    					} else {
    						server_reply = "Too many clients in parameters";
    					}
    				}
    				
    				if (cmd.equals("sendMouseCoords")){
    					if (params.length == 2){
    						client_mice.put(user_id, params[0] + "," + params[1]);
    						
    						server_reply = "success";
    					} else {
    						server_reply = "failed";
    					}
    				}
    				
    				if (cmd.equals("getMouseCoords")){
    					server_reply = mousePositions(user_id);
    				}
    				
    				if (cmd.equals("open") || cmd.equals("close") || cmd.equals("openForm") || cmd.equals("closeForm") || cmd.equals("writeTerminal") || cmd.equals("updateCompiler")){
    					for (int i = 0; i < client_count; i++){
    						String cur = client_unread_commands.get(clients[i]);
    						client_unread_commands.put(clients[i],cur + line + "$");
    					}
    				}
    				
    				if (cmd.equals("mkdir")){
    					Mainscreen MS = new Mainscreen();
    				 MS.AddFolder(params[0], params[1]);
    				 server_reply = "success";
    				}
    				
    				if (cmd.equals("cd")){
    					FileManager fm = new FileManager();
    					if(params.length == 2)
    					{
    						if(fm.cd(params[0], params[1]))
    						{
    							server_reply = "success";
    						}else{server_reply = "failed";}
    					}else{server_reply = "failed";}
    				}
    				
    				if (cmd.equals("ls")){
    					FileManager fm = new FileManager();
    					fm.ls(params[0]);
    					server_reply = "success";
    				}
    				
    				if (cmd.equals("readCommands")){
    					server_reply = client_unread_commands.get(user_id);
    					client_unread_commands.put(user_id,"");
    				}
    				}
    				bw.write(server_reply + "\n");
    				bw.flush();
    			}
    			
    			bw.close();
    			br.close();
    			socket.close();
    		}
    	} catch (IOException ex) {
    		ex.printStackTrace();
    	}
    }
    
    private static String mousePositions(String user_id){
    	String mousePos = "";
    	
    	for (int i = 0; i < client_count; i++){
    		if (user_id.equals(clients[i]) == false){
    			String pos = client_mice.get(clients[i]);
    			mousePos += "mouseCoords:null:" + clients[i] + ":" + pos + "$";
    		}
    	}

    	return mousePos;
    }
}
