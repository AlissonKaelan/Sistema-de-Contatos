<?php
class Contato {
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function salvar($nome, $telefone, $mensagem, $dataHora) {
        $sql = "INSERT INTO contatos (nome, telefone, mensagem, data_hora) 
                VALUES (:nome, :telefone, :mensagem, :dataHora)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':mensagem', $mensagem);
        $stmt->bindParam(':dataHora', $dataHora);
        return $stmt->execute();
    }

    public function telefoneExiste($telefone) {
        $query = "SELECT COUNT(*) as total FROM contatos WHERE telefone = :telefone";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] > 0;
    }


    public function excluir($id) {
    $sql = "DELETE FROM contatos WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    return $stmt->execute();
}
}


?>