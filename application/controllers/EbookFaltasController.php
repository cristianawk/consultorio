<?php
/**
 * Created by PhpStorm.
 * User: cristian
 * Date: 25/07/16
 * Time: 11:29
 */

class EbookFaltasControler extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('template_ebook_faltas/index');
    }

    public function contato()
    {
        $this->load->view('template_ebook_faltas/contato');
    }

    public function envia()
    {
        $subject = 'Mensagem encaminhada pelo ebook-faltas por: '.$this->input->post('nome').' perfil: '.$this->input->post('perfil');
        //clickconsultorio@outlook.com

        $this->load->library("my_phpmailer");
        $mail = new PHPMailer();
        $mail->IsSMTP(); //Definimos que usaremos o protocolo SMTP para envio.
        $mail->SMTPAuth = true; //Habilitamos a autenticação do SMTP. (true ou false)
        $mail->SMTPSecure = "tls"; //Estabelecemos qual protocolo de segurança será usado.
        $mail->Host = "smtp.live.com"; //Podemos usar o servidor do gMail para enviar.
        $mail->Port = 587; //Estabelecemos a porta utilizada pelo servidor do gMail.
        $mail->Username = "clickconsultorio@outlook.com"; //Usuário do gMail
        $mail->Password = "awk@2016"; //Senha do gMail
        $mail->SetFrom($this->input->post('email'),$this->input->post('nome')); //Quem está enviando o e-mail.
        //$mail->AddReplyTo($this->input->post('email'),$this->input->post('nome')); //Para que a resposta será enviada.
        $mail->Subject = utf8_decode($subject); //Assunto do e-mail.
        $mail->Body = $this->input->post('mensagem');
        $mail->AltBody = $this->input->post('mensagem');
        $destino = "contato@clickconsultorio.com";
        $mail->AddAddress($destino, "Ebook-Faltas Click Consultorio");

        /*Também é possível adicionar anexos.*/
        //$mail->AddAttachment("images/phpmailer.gif");
        // $mail->AddAttachment("images/phpmailer_mini.gif");

        if(!$mail->Send()) {
            $data["message"] = "ocorreu um erro durante o envio: " . $mail->ErrorInfo;
            echo $mail->ErrorInfo;die;
        } else {
            $data["message"] = "Mensagem enviada com sucesso!";
        }

        /*$data['to'] = "contato@clickconsultorio.com";
        $data['from'] = $this->input->post('email');
        $data['subject'] = $subject;
        $data['message'] = $this->input->post('mensagem');

        $this->db->insert('cron', $data);*/
        return redirect('/ebook-faltas');
    }

}