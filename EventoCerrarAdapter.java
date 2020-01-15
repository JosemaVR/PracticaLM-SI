package eventos;

import java.awt.*;
import java.awt.event.*;

public class EventoCerrarAdapter extends WindowAdapter {

	Frame frame1 = new Frame("Boton cerrar");

	public EventoCerrarAdapter() {
		frame1.setLayout(new FlowLayout());
		frame1.setTitle("Primera prueba");
		frame1.setSize(200, 200);
		frame1.addWindowListener(this);
		frame1.setVisible(true);
		frame1.addWindowListener(this);
	}

	public static void main(String[] args) {
		new EventoCerrarAdapter();

	}

	// A continuación debemos colocar TODOS los métodos de la clase
	// abstracta WindowListener, aunque solamente vayamos a trabajar
	// con el método windowClosing()
	public void windowActivated(WindowEvent we) {
	}

	public void windowClosed(WindowEvent we) {
	}

	public void windowClosing(WindowEvent we) {
		// Llamamos al método exit de la clase System,
		// devolviendo como código de salida un 0
		System.exit(0);
	}

	public void windowDeactivated(WindowEvent we) {
	}

	public void windowDeiconified(WindowEvent we) {
	}

	public void windowIconified(WindowEvent we) {
	}

	public void windowOpened(WindowEvent we) {
	}
}
