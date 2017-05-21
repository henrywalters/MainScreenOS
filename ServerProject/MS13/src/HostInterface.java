import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JOptionPane;

public class HostInterface {
    public static void main(final String[] args) {

    }
    
    public static String prompt_session_name(){
    	final JFrame parent = new JFrame();
    	String session_name = JOptionPane.showInputDialog(parent,"What would you like to call this session?",null);
    	return session_name;
    }
    
    public static int prompt_port(){
    	final JFrame parent = new JFrame();
    	int port = Integer.parseInt(JOptionPane.showInputDialog(parent,"What port [1000 - 9999] would you like to connect to?",null));
    	return port;
    }
    
    public static int prompt_port_bad_attempt(){
    	final JFrame parent = new JFrame();
    	int port = Integer.parseInt(JOptionPane.showInputDialog(parent,"That port is already taken, please choose again:",null));
    	return port;
    }
    

}
