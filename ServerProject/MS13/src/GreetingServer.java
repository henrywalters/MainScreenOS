// File Name GreetingServer.java
import java.net.*;
import java.io.*;

public class GreetingServer extends Thread {
   private ServerSocket serverSocket;
   
   private Integer count = 0;
   private Integer m_x = 0;
   private Integer m_y = 0;
   public GreetingServer(int port) throws IOException {
      serverSocket = new ServerSocket(port);
      //serverSocket.bind(new InetSocketAddress("24.127.230.210",port));
      serverSocket.setSoTimeout(60*60*1000);
   }

   public void run() {
      while(true) {
    	 CreateDialogFromOptionPane pane = new CreateDialogFromOptionPane();
         try {
            System.out.println("Waiting for client on port " + 
               serverSocket.getLocalPort() + "...");
            Socket server = serverSocket.accept();
            
            System.out.println("Just connected to " + server.getRemoteSocketAddress());
            BufferedReader in = new BufferedReader(new InputStreamReader(server.getInputStream()));
            long millis = System.currentTimeMillis() % 1000;
            //long currentTime = Long.parseLong(in.readUTF());
            
            DataOutputStream out = new DataOutputStream(server.getOutputStream());
            //in.close();
            //out.writeUTF(String.tO);
            //out.flush();
            String inputLine, outputLine;
            
            inputLine = in.readLine();
            String[] input = inputLine.split("[|]");
            System.out.println(input[0]);
            //System.out.println(inputLine);
            
            if (input[0].equals("$sendMouse")){
            	m_x = Integer.parseInt(input[1].split(":")[1]);
            	m_y = Integer.parseInt(input[2].split(":")[1]);
            	System.out.println(m_x);
            }
            
            //if (input[0].equals("$getMouse")){
            	//System.out.println("sent Mouse");
            out.writeUTF(Integer.toString(m_x) + "|" + Integer.toString(m_y));
            //}
            
            //out.writeUTF(inputLine);
            //for (int i = 0; i < inputLine.length(); i++){
            	//System.out.println(inputLine);
            //}
         }catch(SocketTimeoutException s) {
            System.out.println("Socket timed out!");
            break;
         }catch(IOException e) {
            e.printStackTrace();
            break;
         }
      }
   }
   
   public static void main(String[] args) {

	      int port = 6300;
	      int backlog = 0;
	      String host = "141.217.175.129";
	      try {
	         Thread t = new GreetingServer(port);
	         t.start();
	      }catch(IOException e) {
	         e.printStackTrace();
	         System.out.println("port");
	      }
	   
   }
}