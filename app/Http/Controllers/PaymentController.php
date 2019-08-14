<?php

namespace App\Http\Controllers;

use App\User;
use App\UserWallet;
use App\UserPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    private $sender_id;
    private $recipint_id;
    private $amount;

    /**
     * @param Request $request
     */
    public function sendMoneyToUser(Request $request)
    {
        $payment_id = 0;

        // Получаем даннные пользователей (от кого и кому), а также количество переводимых средств
        $this->sender_id = $request->input('sender_id');
        $this->recipint_id = $request->input('recipint_id');
        $this->amount = $request->input('amount');

        // Будем оборачивать все это дело в транзакцию
        // чтобы контролировать процесс передачи денег и не потерять их в процессе
        try {
            // Сама транзакция
            $payment_id = $this->paymentTransaction();
        } catch (\PDOException $e) {
            return response('Возникла ошибка во время операции.');

            DB::rollBack();
        }

        return response()->json([
            "user_sender" => User::find($this->sender_id),
            "user_recipint" => User::find($this->recipint_id),
            "amount" => UserPayment::find($payment_id)->amount
        ]);
    }

    /**
     * @return mixed
     */
    private function paymentTransaction()
    {
        DB::beginTransaction();

        // Меняем оставшиеся деньги у пользовтаелей в кошельке
        $this->changeAmountOfMoney();

        // Сама платежка
        $payment = new UserPayment($this->sender_id, $this->recipint_id);
        $payment->savePayment();

        DB::commit();

        return $payment->id;
    }

    /**
     * Изменяем количество денежных средств в кошельке пользователя
     */
    private function changeAmountOfMoney()
    {
        $sender = UserWallet::find($this->sender_id);
        $recipint = UserWallet::find($this->recipint_id);

        $sender->money = $sender->money - $this->amount;
        $recipint->money = $recipint->money + $this->amount;
    }
}
