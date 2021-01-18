var base_url = window.location.origin;

$('#form1').submit(function(e){
    e.preventDefault();

    var u_nome = $('#inputNome').val();
    var u_email = $('#inputEmail').val();
    var u_telefone = $('#inputTelefone').val();
    var u_msg = $('#inputTextarea').val();


    console.log(base_url);
    $.ajax({
        url: base_url + '/php/usecar/php/inserir.php',
        method: 'POST',
        data: {name: u_nome, email:u_email, telefone:u_telefone, mensagem:u_msg},
        dataType: 'json'
    }).done(function(result){
        Swal.fire({
            title: 'Agradecemos o contato e responderemos em breve!',
            text: 'Clique no botão para fechar a solicitação',
            icon: 'success',
        })

        $('#inputNome').val('');
        $('#inputEmail').val('');
        $('#inputTelefone').val('');
        $('#inputTextarea').val('');
        //console.log(result);
    });
});