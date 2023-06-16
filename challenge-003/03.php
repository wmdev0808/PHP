<?php

class Conversation {}

$obj = new Conversation();

// switch (get_class($obj)) {
//   case 'Conversation':
//     $type = 'started_conversation';
//     break;
  
//   case 'Reply':
//     $type = 'replied_to_conversation';
//     break;

//   case 'Comment':
//     $type = 'commented_on_lesson';
//     break;
// }

$type = match (get_class($obj)) {
    'Conversation' => 'started_conversation',
    'Reply'=> 'replied_to_conversation',
    'Comment' => 'commented_on_lesson'
};

echo $type;