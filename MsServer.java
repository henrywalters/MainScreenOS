import java.net.*;
import java.io.*;

public class MsServer {
    public static void main(final String[] args) {
    	HostInterface ui = new HostInterface();
    	String session_name = ui.prompt_session_name();
    	int port = ui.prompt_port();
    	
    	ServerSocket listening = null;
    	Socket socket = null;
    	
    	String[] clients = new String[4];
    	int client_count = 0;
    	
    	try {
    		listening = new ServerSocket(port);
    		System.out.println("Server Running...");
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
    				String cmd = lines[0];
    				String object_id = lines[1];
    				String user_id = lines[2];
    				String params[] = lines[3].split(",");
    				
    				System.out.println(lines[0]);
    				
    				if (cmd.equals("add client")){
    					
    					if (params.length == 1 && params[0].length() > 0){
    						clients[client_count] = params[0];
    						client_count += 1;
    						server_reply = "success";
    					} else if (params.length == 1 && params[0].length() == 0){
    						server_reply = "user_id can't be empty";
    					} else {
    						server_reply = "Too many clients in parameters";
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
}
