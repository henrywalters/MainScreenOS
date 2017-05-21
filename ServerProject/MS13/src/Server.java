import java.net.*;
import java.io.*;
public class Server {
	public static void main(String[] args) {
		int port = 4201;
		ServerSocket listenSock = null; //the listening server socket
		Socket sock = null;			 //the socket that will actually be used for communication
		String m_x = "";
		String m_y = "";
		try {

			listenSock = new ServerSocket(port);

			while (true) {	   //we want the server to run till the end of times

				sock = listenSock.accept();			 //will block until connection recieved

				BufferedReader br =	new BufferedReader(new InputStreamReader(sock.getInputStream()));
				BufferedWriter bw =	new BufferedWriter(new OutputStreamWriter(sock.getOutputStream()));
				
				String line = "";
				while ((line = br.readLine()) != null) {
					String reply = "";
					System.out.println("working");
					if (line.split("[:]")[0].equals("getMouse")){
						reply = m_x + "," + m_y;
					}
					if (line.split("[:]")[0].equals("sendMouse")){
						String[] params = line.split(":")[1].split(",");
						m_x = params[0];
						m_y = params[1];
						reply = "Mouse Set";
					}
					bw.write(reply + "\n");
					bw.flush();

				}

				//Closing streams and the current socket (not the listening socket!)
				bw.close();
				br.close();
				sock.close();
			}
		} catch (IOException ex) {
			ex.printStackTrace();
		}
	}
}
