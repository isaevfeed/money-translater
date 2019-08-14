<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    private $sender;
    private $recipint;

    /**
     * Проще все спрятать в конструктор
     * UserPayment constructor.
     * @param int $sender
     * @param int $recipint
     */
    public function __construct(int $sender, int $recipint)
    {
        $this->sender = $sender;
        $this->recipint = $recipint;
    }

    /**
     * Проиводим перевод
     * @return bool|void
     */
    public function save()
    {
        $payment = new UserPayment();
        $payment->sender = $this->sender;
        $payment->recipint = $this->recipint;
        $payment->save();
    }
}
