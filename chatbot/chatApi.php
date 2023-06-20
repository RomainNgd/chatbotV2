<?php
require_once __DIR__ . '/Service/ChatService.php';
session_start();
use Chatbot\Service\ChatService;

$chatService = new ChatService();
//unset($_SESSION['lastkeyword']);
//unset($_SESSION['product']);
//unset($_SESSION['panier']);
//$reponse = $chatService->findMessage('je veux ajouter au panier');
//var_dump($reponse);
//echo '<br/>';
//$reponse = $chatService->findMessage('playmobil');
//var_dump($reponse);
//echo '<br/>';
//var_dump($_SESSION['product']);
//$reponse = $chatService->findMessage('ajouter au panier');
//var_dump($reponse);
//echo '<br/>';
//$reponse = $chatService->findMessage('voir le panier');
//var_dump($reponse);
//$reponse = $chatService->findMessage('supprimer du panier');
//var_dump($reponse);
//$reponse = $chatService->findMessage('5');
//var_dump($reponse);
//$reponse = $chatService->findMessage('voir le panier');
//var_dump($reponse);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['method']) && $data['method'] === 'findMessage') {
        $result = $chatService->findMessage($data['message']);
        if (isset($_SESSION['lastkeyword']) == 'password'){
            echo json_encode(['success' => true, 'result' => $result, 'password' => true]);
        } else {
            echo json_encode(['success' => true, 'result' => $result, 'password'=> false]);
        }

    }elseif (isset($data['method']) && $data['method'] === 'resetChat'){
        $result = $chatService->resetChat($data['message']);
        echo json_encode(['success' => true, 'result' => $result]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Method not found']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}