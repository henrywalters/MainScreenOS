// File Name GreetingClient.java
import java.net.*;
import java.io.*;


public class GreetingClient {

   public static void main(String [] args) {
      //String serverName = "24.127.230.210";

	  
	  CreateDialogFromOptionPane pane = new CreateDialogFromOptionPane();
	  String serverName = pane.prompt_host();
	  int port = pane.prompt_port();
	  
	  
      try {
         System.out.println("Connecting to " + serverName + " on port " + port);
         Socket client = new Socket(serverName, port);
         
         System.out.println("Just connected to " + client.getRemoteSocketAddress());
         OutputStream outToServer = client.getOutputStream();
         DataOutputStream out = new DataOutputStream(outToServer);
         
         long millis = System.currentTimeMillis() % 1000;
         out.writeUTF(Long.toString(millis));
         InputStream inFromServer = client.getInputStream();
         DataInputStream in = new DataInputStream(inFromServer);
         Boolean running = true;
         
         while (running == true){
        	 out = new DataOutputStream(outToServer);
        	 String msg = pane.send_message();
        	 out.writeUTF(msg);
        	 
         }
         
         client.close();
      }catch(IOException e) {
         e.printStackTrace();
         pane.output("Server didn't respond");
      }
   }
   
}