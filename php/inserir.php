<?php
    //var_dump($_POST['name']); exit();
    require_once('../src/PHPMailer.php');
    require_once('../src/SMTP.php');
    require_once('../src/Exception.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    header('Content-Type: application/json');
    $data = new DateTime();
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'contato@usecargo.mobi';
        $mail->Password = 'Q6=rH4ym';
        $mail->Port = 587;

        $mail->setFrom('contato@usecargo.mobi');
        $mail->addAddress('contato@usecargo.mobi');

        $mensagem = "Nome do usuario (a): " .$_POST['name']. "<br>";
        $mensagem .= "Email:" .$_POST['email']. " <br>";
        $mensagem .= "Telefone:" .$_POST['telefone']. "<br>";
        $mensagem .= "Mensagem:" .$_POST['mensagem']. "<br>";
        $mensagem .= "Data:" .$data->format('d-m-Y H:i:s'). "<br>";

        
        $mail->isHTML(true);
        $mail->Subject = 'Formulario de contato UseCar Carsharing';
        $mail->Body = $mensagem;
        $mail->AltBody = $mensagem;

        $mail->send();
    } catch (Exception $e) {
        echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
    }
    
    $pdo = new PDO('mysql:host=localhost; dbname=usecar_bd;', 'root', '');

    $stmt = $pdo->prepare('INSERT INTO uc_form_contato (uc_form_nome, uc_form_email, uc_form_telefone, uc_form_text_area) 
        VALUES (:no, :em, :te, :tx)');
    $stmt->bindValue(':no', $_POST['name']);
    $stmt->bindValue(':em', $_POST['email']);
    $stmt->bindValue(':te', $_POST['telefone']);
    $stmt->bindValue(':tx', $_POST['mensagem']);
    $stmt->execute();

    if ($stmt->rowCount() >= 1) {
        echo json_encode('Comentário e email Salvo com Sucesso');
    } else {
        echo json_encode('Falha ao salvar comentário');
    }