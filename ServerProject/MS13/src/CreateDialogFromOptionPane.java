import javax.swing.JButton;
import javax.swing.JFrame;
import javax.swing.JOptionPane;

public class CreateDialogFromOptionPane {

    public static void main(final String[] args) {

    }
    
    public static String prompt_host(){
    	final JFrame parent = new JFrame();
        JButton button = new JButton();
        String name = JOptionPane.showInputDialog(parent,
                "Host: ", null);    
        return name;
    }
    
    public static int prompt_port(){
    	final JFrame parent = new JFrame();
        JButton button = new JButton();
        String port = JOptionPane.showInputDialog(parent,"Port: ", null);
        return Integer.parseInt(port);
    }
    
    public String send_message(){
    	final JFrame parent = new JFrame();
    	String message = JOptionPane.showInputDialog(parent,"Send Message: ");
    	return message;
    	
    }
    
    public void output(String message){
    	final JFrame parent = new JFrame();
    	JOptionPane.showMessageDialog(parent, message);
    }
}