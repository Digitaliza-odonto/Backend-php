<?php

require_once('db.php');

// Obtenha a rota da URL
$rota = $_GET['rota'];

// Defina os cabeçalhos CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With, content-type');
header('Access-Control-Allow-Credentials: true');

// Manipule as rotas
switch ($rota) {
    case '/':
        // Rota principal
        $name = "Prontuário-UFPel";
        $version = "1.0.0";
        $build = "success";
        $response = array("name" => $name, "version" => $version, "build" => $build);
        echo json_encode($response);
        break;

        case '/pacientes/criar':
            // Verifica se a solicitação é um POST
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Obtenha os dados do paciente do corpo da solicitação JSON
                $data = json_decode(file_get_contents('php://input'), true);
        
                // Verifique se todos os campos necessários foram fornecidos
                if (
                    isset($data['CPF']) && isset($data['Nome']) && isset($data['Rg']) &&
                    isset($data['DataNasc']) && isset($data['Email']) && isset($data['Tel']) &&
                    isset($data['EstadoCivil']) && isset($data['Sexo']) && isset($data['NomeMae']) &&
                    isset($data['NomePai']) && isset($data['CorRaca']) && isset($data['PNE']) &&
                    isset($data['EnderecoTipo']) && isset($data['Cep']) && isset($data['Rua']) &&
                    isset($data['EndNumero']) && isset($data['EndComplemento']) && isset($data['Bairro']) &&
                    isset($data['Cidade'])
                ) {
                    // Dados do paciente
                    $CPF = $data['CPF'];
                    $Nome = $data['Nome'];
                    $Rg = $data['Rg'];
                    $DataNasc = $data['DataNasc'];
                    $Email = $data['Email'];
                    $Tel = $data['Tel'];
                    $EstadoCivil = $data['EstadoCivil'];
                    $Sexo = $data['Sexo'];
                    $NomeMae = $data['NomeMae'];
                    $NomePai = $data['NomePai'];
                    $CorRaca = $data['CorRaca'];
                    $PNE = $data['PNE'];
                    $EnderecoTipo = $data['EnderecoTipo'];
                    $Cep = $data['Cep'];
                    $Rua = $data['Rua'];
                    $EndNumero = $data['EndNumero'];
                    $EndComplemento = $data['EndComplemento'];
                    $Bairro = $data['Bairro'];
                    $Cidade = $data['Cidade'];
        
                    // Executar a inserção no banco de dados (substitua com sua lógica de inserção)
                    $query = "INSERT INTO pacientes (CPF, Nome, Rg, DataNasc, Email, Tel, EstadoCivil, Sexo, NomeMae, NomePai, CorRaca, PNE, EnderecoTipo, Cep, Rua, EndNumero, EndComplemento, Bairro, Cidade)
                              VALUES ('$CPF', '$Nome', '$Rg', '$DataNasc', '$Email', '$Tel', '$EstadoCivil', '$Sexo', '$NomeMae', '$NomePai', '$CorRaca', '$PNE', '$EnderecoTipo', '$Cep', '$Rua', '$EndNumero', '$EndComplemento', '$Bairro', '$Cidade')";
        
                    if (db($query)) {
                        // Inserção bem-sucedida
                        $response = array("message" => "Paciente criado com sucesso");
                        echo json_encode($response);
                    } else {
                        // Erro na inserção
                        http_response_code(500);
                        echo json_encode(array("error" => "Erro ao criar paciente no banco de dados"));
                    }
                } else {
                    // Campos obrigatórios ausentes
                    http_response_code(400);
                    echo json_encode(array("error" => "Todos os campos obrigatórios devem ser fornecidos"));
                }
            } else {
                // Método de solicitação inválido
                http_response_code(405);
                echo json_encode(array("error" => "Método de solicitação inválido. Use POST."));
            }
            break;
        

            case '/pacientes/consultar':
                // Verifica se a solicitação é um POST
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Obtenha os dados da solicitação JSON
                    $data = json_decode(file_get_contents('php://input'), true);
            
                    // Verifique se o campo de consulta (CPF ou Nome) foi fornecido
                    if (isset($data['CPF']) || isset($data['Nome'])) {
                        $query = "SELECT * FROM pacientes WHERE";
            
                        if (isset($data['CPF'])) {
                            $query .= " CPF = '" . $data['CPF'] . "'";
                        }
            
                        if (isset($data['CPF']) && isset($data['Nome'])) {
                            $query .= " OR";
                        }
            
                        if (isset($data['Nome'])) {
                            $query .= " Nome LIKE '%" . $data['Nome'] . "%'";
                        }
            
                        // Execute a consulta no banco de dados (substitua pela sua lógica)
                        $result = db($query);
            
                        if ($result->num_rows > 0) {
                            $pacientes = array();
                            while ($row = $result->fetch_assoc()) {
                                $pacientes[] = $row;
                            }
                            echo json_encode($pacientes);
                        } else {
                            echo json_encode(array("message" => "Nenhum paciente encontrado."));
                        }
                    } else {
                        // Campos de consulta ausentes
                        http_response_code(400);
                        echo json_encode(array("error" => "Informe CPF ou Nome para consulta."));
                    }
                } else {
                    // Método de solicitação inválido
                    http_response_code(405);
                    echo json_encode(array("error" => "Método de solicitação inválido. Use POST."));
                }
                break;
            

    case '/pacientes/atualizar':
        // Rota para atualizar pacientes
        // ... Seu código de atualização de pacientes aqui ...
        break;

    case '/encaminhamentos/consultar':
        // Rota para consultar encaminhamentos
        // ... Seu código de consulta de encaminhamentos aqui ...
        break;

    case '/encaminhamentos/criar':
        // Rota para criar encaminhamentos
        // ... Seu código de criação de encaminhamentos aqui ...
        break;

    case '/encaminhamentos/atualizar':
        // Rota para atualizar encaminhamentos
        // ... Seu código de atualização de encaminhamentos aqui ...
        break;

    // Adicione outras rotas aqui...

    default:
        // Rota desconhecida
        http_response_code(404);
        echo json_encode(array("error" => "Rota desconhecida"));
        break;
}
?>
