<?php
require __DIR__ . '/../config/config.php';
$conn = Conexao::getConn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recebendo e limpando os dados (exemplo simples)
    $nome = trim($_POST['nome'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $rg = trim($_POST['rg'] ?? '');
    $id_cargo = intval($_POST['cargo'] ?? 0);
    $data_admissao = $_POST['data_admissao'] ?? null;
    $salario = floatval(str_replace(',', '.', $_POST['salario'] ?? 0));

    $cep = trim($_POST['cep'] ?? '');
    $rua = trim($_POST['rua'] ?? '');
    $bairro = trim($_POST['bairro'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $estado = trim($_POST['estado'] ?? '');

    $ddd = trim($_POST['ddd'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');

    // Validações simples
    if (!$nome || !$cpf || !$rg || !$id_cargo || !$data_admissao || !$salario) {
        die('Por favor, preencha todos os campos obrigatórios.');
    }

    try {
        $conn->beginTransaction();

        // Inserir na tabela FUNCIONARIO
        $sqlFuncionario = "INSERT INTO FUNCIONARIO (nome_funcionario, cpf_funcionario, rg_funcionario, id_cargo, data_admissao, salario)
                           VALUES (:nome, :cpf, :rg, :id_cargo, :data_admissao, :salario)";
        $stmt = $conn->prepare($sqlFuncionario);
        $stmt->execute([
            ':nome' => $nome,
            ':cpf' => $cpf,
            ':rg' => $rg,
            ':id_cargo' => $id_cargo,
            ':data_admissao' => $data_admissao,
            ':salario' => $salario
        ]);

        // Pegar id_funcionario inserido
        $id_funcionario = $conn->lastInsertId();

        // Inserir endereço do funcionário
        $sqlEndereco = "INSERT INTO endereco_funcionario (cep_funcionario, rua_funcionario, bairro_funcionario, cidade_funcionario, estado_funcionario, id_funcionario)
                        VALUES (:cep, :rua, :bairro, :cidade, :estado, :id_funcionario)";
        $stmt = $conn->prepare($sqlEndereco);
        $stmt->execute([
            ':cep' => $cep,
            ':rua' => $rua,
            ':bairro' => $bairro,
            ':cidade' => $cidade,
            ':estado' => $estado,
            ':id_funcionario' => $id_funcionario
        ]);

        // Inserir telefone do funcionário
        $sqlTelefone = "INSERT INTO telefone_funcionario (ddd_funcionario, num_telefone_funcionario, id_funcionario)
                        VALUES (:ddd, :telefone, :id_funcionario)";
        $stmt = $conn->prepare($sqlTelefone);
        $stmt->execute([
            ':ddd' => $ddd,
            ':telefone' => $telefone,
            ':id_funcionario' => $id_funcionario
        ]);

        $conn->commit();

        echo "Funcionário cadastrado com sucesso!";
        // header('Location: funcionarios.php'); // Descomente para redirecionar

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Erro ao cadastrar funcionário: " . $e->getMessage();
    }

} else {
    echo "Método inválido.";
}
