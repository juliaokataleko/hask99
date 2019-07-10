<?php
require_once 'core/init.php';
require_once'functions/functions.php';
acessLog($absolute_url);
$user = new User();
if($user->isLoggedIn()){
	
	$username = $user->data()->username;
}
if(isset($user) && $user->isLoggedIn()){
	$notification = new Notification();
	$notification->findNotification($user->data()->user_id);
	$total = $notification->_db->count();
}
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
	<meta charset="utf-8"/>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
	<title>Plítica de Privacidade - Pennsub.com</title>
	<link href="includes/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/home.css" />
	<link rel="icon" href="includes/img/logo.png" sizes="57x57" type="image/png">
	
</head>
<body style="margin-top:0;">


<link rel = "stylesheet" type = "text/css" href = "includes/assets/css/all.css" />

<?php include 'includes/html/header.html';?>

<div class="content" style="">
<h1>Política de privacidade</h1><hr/>



    <h4>SEÇÃO 1 - O QUE FAREMOS COM ESTA INFORMAÇÃO?</h4>
<p>Quando você realiza alguma transação com nossa loja, como parte do processo de compra e venda, coletamos as informações pessoais que você nos dá tais como: nome, e-mail e endereço.</p>
<p>Quando você acessa nosso site, também recebemos automaticamente o protocolo de internet do seu computador, endereço de IP, a fim de obter informações que nos ajudam a aprender sobre seu navegador e sistema operacional.</p>
<p>Email Marketing será realizado apenas caso você permita. Nestes emails você poderá receber notícia sobre nossa loja, novos produtos e outras atualizações.</p>
<h4>SEÇÃO 2 - CONSENTIMENTO</h4>
<p>Como vocês obtêm meu consentimento?</p>
<p>Quando você fornece informações pessoais como nome, telefone e endereço, para completar: uma transação, verificar seu cartão de crédito, fazer um pedido, providenciar uma entrega ou retornar uma compra. Após a realização de ações entendemos que você está de acordo com a coleta de dados para serem utilizados pela nossa empresa.</p>
<p>Se pedimos por suas informações pessoais por uma razão secundária, como marketing, vamos lhe pedir diretamente por seu consentimento, ou lhe fornecer a oportunidade de dizer não.</p>
<p>E caso você queira retirar seu consentimento, como proceder?</p>
<p>Se após você nos fornecer seus dados, você mudar de ideia, você pode retirar o seu consentimento para que possamos entrar em contato, para a coleção de dados contínua, uso ou divulgação de suas informações, a qualquer momento, entrando em contato conosco em <b>juliofeli78@gmail.com</b> ou nos enviando uma correspondência em: <b>Pennsub</b> <b>Benguela, Angola</b></p>
<h4>SEÇÃO 3 - DIVULGAÇÃO</h4>
<p>Podemos divulgar suas informações pessoais caso sejamos obrigados pela lei para fazê-lo ou se você violar nossos Termos de Serviço.</p>
<h4>SEÇÃO 4 - SERVIÇOS DE TERCEIROS</h4>
<p>No geral, os fornecedores terceirizados usados por nós irão apenas coletar, usar e divulgar suas informações na medida do necessário para permitir que eles realizem os serviços que eles nos fornecem.</p>
<p>Entretanto, certos fornecedores de serviços terceirizados, tais como gateways de pagamento e outros processadores de transação de pagamento, têm suas próprias políticas de privacidade com respeito à informação que somos obrigados a fornecer para eles de suas transações relacionadas com compras.</p>
<p>Para esses fornecedores, recomendamos que você leia suas políticas de privacidade para que você possa entender a maneira na qual suas informações pessoais serão usadas por esses fornecedores.</p>
<p>Em particular, lembre-se que certos fornecedores podem ser localizados em ou possuir instalações que são localizadas em jurisdições diferentes que você ou nós. Assim, se você quer continuar com uma transação que envolve os serviços de um fornecedor de serviço terceirizado, então suas informações podem tornar-se sujeitas às leis da(s) jurisdição(ões) nas quais o fornecedor de serviço ou suas instalações estão localizados.</p>
<p>Como um exemplo, se você está localizado no Canadá e sua transação é processada por um gateway de pagamento localizado nos Estados Unidos, então suas informações pessoais usadas para completar aquela transação podem estar sujeitas a divulgação sob a legislação dos Estados Unidos, incluindo o Ato Patriota.</p>
<p>Uma vez que você deixe o site da nossa loja ou seja redirecionado para um aplicativo ou site de terceiros, você não será mais regido por essa Política de Privacidade ou pelos Termos de Serviço do nosso site.</p>
<p>Links</p>
<p>Quando você clica em links na nossa loja, eles podem lhe direcionar para fora do nosso site. Não somos responsáveis pelas práticas de privacidade de outros sites e lhe incentivamos a ler as declarações de privacidade deles.</p>
<h4>SEÇÃO 5 - SEGURANÇA</h4>
<p>Para proteger suas informações pessoais, tomamos precauções razoáveis e seguimos as melhores práticas da indústria para nos certificar que elas não serão perdidas inadequadamente, usurpadas, acessadas, divulgadas, alteradas ou destruídas.</p>
<p>Se você nos fornecer as suas informações de cartão de crédito, essa informação é criptografada usando tecnologia "secure socket layer" (SSL) e armazenada com uma criptografia AES-256. Embora nenhum método de transmissão pela Internet ou armazenamento eletrônico é 100% seguro, nós seguimos todos os requisitos da PCI-DSS e implementamos padrões adicionais geralmente aceitos pela indústria.</p>
<h4>SEÇÃO 6 - ALTERAÇÕES PARA ESSA POLÍTICA DE PRIVACIDADE</h4>
<p>Reservamos o direito de modificar essa política de privacidade a qualquer momento, então por favor, revise-a com frequência. Alterações e esclarecimentos vão surtir efeito imediatamente após sua publicação no site. Se fizermos alterações de materiais para essa política, iremos notificá-lo aqui que eles foram atualizados, para que você tenha ciência sobre quais informações coletamos, como as usamos, e sob que circunstâncias, se alguma, usamos e/ou divulgamos elas.</p>
<p>Se nossa loja for adquirida ou fundida com outra empresa, suas informações podem ser transferidas para os novos proprietários para que possamos continuar a vender produtos para você.</p>


</div>

<?php include 'includes/html/footer.html';?>
