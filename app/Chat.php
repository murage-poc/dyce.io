<?php
/**
 * Created by PhpStorm.
 * User: mimidots
 * Date: 6/2/2018
 * Time: 8:21 AM
 */

namespace io;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Chat implements MessageComponentInterface
{

    protected $clients;

    /**
     * Chat constructor.
     */
    public function __construct()
    {
        $this->clients=new \SplObjectStorage();
    }

    /**
     * When a new connection is opened it will be passed to this method
     * @param  ConnectionInterface $conn The socket/connection that just connected to your application
     * @throws \Exception
     */
    function onOpen(ConnectionInterface $conn)
    {

        //add client to object for sending message later
        $this->clients->attach($conn);
        echo "new connection {$conn->resourceId}\n";
    }

    /**
     * This is called before or after a socket is closed (depends on how it's closed).  SendMessage to $conn will not result in an error if it has already been closed.
     * @param  ConnectionInterface $conn The socket/connection that is closing/closed
     * @throws \Exception
     */
    function onClose(ConnectionInterface $conn)
    {

        $this->clients->detach($conn); //remove the connection
        echo "Connection {$conn->resourceId} disconnected \n";    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Connection error: {$e->getMessage()}";
        $conn->close();
    }

    /**
     * Triggered when a client sends data through the socket
     * @param  \Ratchet\ConnectionInterface $from The socket/connection that sent the message to your application
     * @param  string $msg The message received
     * @throws \Exception
     */
    function onMessage(ConnectionInterface $from, $msg)
    {
        $totalClients=count($this->clients)-1; //get number of receiving clients
        echo sprintf("Connection %d sending message '%s' to %d \n",$from->resourceId,$msg,$totalClients);

        foreach ($this->clients as $client){
            if($from!=$client){ //we dont want to send message back to the client
                $client->send($msg);
            }
        }
    }
}