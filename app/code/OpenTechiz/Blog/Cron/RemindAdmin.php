<?php
namespace OpenTechiz\Blog\Cron;

use OpenTechiz\Blog\Helper\CommentCount;
use OpenTechiz\Blog\Helper\Email;

class RemindAdmin
{
    protected $_commentCount;

    protected $_email;
    public function __construct(
        Email $email,
        CommentCount $commentCount
    )
    {
        $this->_commentCount = $commentCount;
        $this->_email = $email;
    }

    public function sendMail()
    {
        $count = $this->_commentCount->countCommentInActive();
        $templateValues = [
            'name'=>'Admin',
            'message'=>'There are '.$count.'comment havent been approve :)'
        ];
        $this->_email->sendMail('pvhung7792@gmail.com',$templateValues);
    }
}
