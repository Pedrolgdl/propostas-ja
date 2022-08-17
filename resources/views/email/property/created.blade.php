<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Template e-mail Proposta Já</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body style="margin: 0; padding: 0;">
  <table style="font-family: Assistant, Arial, sans-serif;" cellpadding="0" cellspacing="0" width="60%" align="center">

    <!-- Cabeçalho -->
    <tr align="center">
      <td style="padding: 30px 30px 30px 30px;">
        <img src="https://ik.imagekit.io/anamaisa/Logo_propostasja_-nTWz8p01.png?ik-sdk-version=javascript-1.4.3&updatedAt=1659725070987" alt="Propostas Já" width="300px">
      </td>
    </tr>

    <!-- Título do E-mail -->
    <tr align="center">
      <td style="padding: 20x 20x 20x 20x; background-color: #EABA2A;">
        <h1>O seu imóvel foi cadastrado com sucesso!</h1>
      </td>
    </tr>

    <!-- Corpo do e-mail -->
    <tr align="center">
      <td style="padding: 30px 5% 30px 5%;">
        Olá, {{ $user->name }},
      
        O seu imóvel {{ $property->title }} foi cadastrado com sucesso e espera aprovação. Quando aprovado, um email será enviado a você.
        
      </td>
    </tr>

    <!-- Rodapé -->
    <tr>
      <td style="padding: 30px 5% 30px 5%; background-color: #264B96; color: white;">
        <table cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td width="30%">
              Alguma mensagem da empresa
            </td>
            <td align="center">
              <table border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <a href="https://www.instagram.com/propostajarj/">
                      <img src="https://ik.imagekit.io/anamaisa/instagram_COuAeLOWj.png?ik-sdk-version=javascript-1.4.3&updatedAt=1659725070904" alt="Instagram Proposta Já" width="80%" height="80%" style="display: block;" border="0" />
                    </a>
                  </td>
                  <td style="font-size: 0; line-height: 0;" width="5%">&nbsp;</td>
                  <td>
                    <a href="">
                      <img src="https://ik.imagekit.io/anamaisa/facebook_iEgrPBDim.png?ik-sdk-version=javascript-1.4.3&updatedAt=1659725070894" alt="Facebook Proposta Já" width="80%" height="80%" style="display: block;" border="0" />
                    </a>
                  </td>
                  <td style="font-size: 0; line-height: 0;" width="5%">&nbsp;</td>
                  <td>
                    <a href="">
                      <img src="https://ik.imagekit.io/anamaisa/linkedin_7Q2LZ3rXW.png?ik-sdk-version=javascript-1.4.3&updatedAt=1659725071026" alt="LinkedIn Proposta Ja" width="80%" height="80%" style="display: block;" border="0" />
                    </a>
                  </td>
                  <td style="font-size: 0; line-height: 0;" width="5%">&nbsp;</td>
                  <td>
                    <a href="">
                      <img src="https://ik.imagekit.io/anamaisa/tiktok_Gc_lVMZSc.png?ik-sdk-version=javascript-1.4.3&updatedAt=1659725070892" alt="Tiktok Proposta Ja" width="80%" height="80%" style="display: block;" border="0" />
                    </a>
                  </td>
                </tr>
              </table>
            </td>
            <td width="30%" align="right"">
              <table>
                <tr>
                  <td>
                    <img style=" display: block;" src="https://ik.imagekit.io/anamaisa/telefone_ojwdcZ5q9.png?ik-sdk-version=javascript-1.4.3&updatedAt=1659725070774" alt="Telefone Proposta Já">
            </td>
            <td>
              <p style="display: block;">(22) 99826-9731</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  </td>
  </tr>
  </table>
</body>

</html>