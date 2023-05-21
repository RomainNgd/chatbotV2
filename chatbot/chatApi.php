<?php
require_once __DIR__ . '/Service/ChatService.php';
session_start();
use Chatbot\Service\ChatService;

$chatService = new ChatService();
//$reponse = $chatService->findMessage('produit');
//var_dump($reponse);
//$reponse = $chatService->findMessage('lzq objet en bois');
//var_dump($reponse);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (isset($data['method']) && $data['method'] === 'findMessage') {
        $result = $chatService->findMessage($data['message']);
        echo json_encode(['success' => true, 'result' => $result]);
    }elseif (isset($data['method']) && $data['method'] === 'resetChat'){
        $result = $chatService->resetChat();
        echo json_encode(['success' => true, 'result' => $result]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Method not found']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}