<?php

    namespace App\Http\Controllers;

    use App\Order;
    use App\OrderBuilder;
    use App\OrderRequestBuilder;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class OrderController extends Controller
    {
        //

        public function createOrder(Request $request)
        {

            $orderBuilder = new OrderBuilder();
            $orderBuilder->setTitle($request->title);
            $orderBuilder->setDescription($request->description);
            $orderBuilder->setComplited($request->complited);
            $item = $orderBuilder->createItem();
            if ($item != null) {
                return response()->json([$item]);
            } else {
                return response()->json([$orderBuilder]);
            }

        }

        public function createOrderRequwest(Request $request)
        {
            if (isset($request->order_id)) {
                $order_id = $request->order_id;
            } else {
                return response(500)->json(["not order_id"]);
            }

            $user = Auth::user();
            if ($user == null) {
                return response(500)->json(["not auth"]);
            }

            $order = Order::getItem($order_id);
            if ($order == null) {
                return response(500)->json(["order not found"]);
            }

            $orderRequwestBuilder = new OrderRequestBuilder();

            $orderRequwestBuilder->setOrderId($order_id);

            $orderRequwestBuilder->setContractorId($user->id);

            $item = $orderRequwestBuilder->createItem();

            return \response()->json([$item]);

        }

        public function markCompleted(Request $request, $id)
        {


            $order_id = intval($id);

            if ($order_id == false) {
                return \response()->json(["wrong id"]);
            }

            $user = Auth::user();
            if ($user == null) {
                return \response()->json(["not auth"]);
            }


            $order = Order::getItem($order_id);
            if ($order == null) {
                return \response();
            }

            $order->markCompleted();

            return \response()->json([$order]);;

        }

    }




    /*
     *     return \response()->json([
                    "anket" => $user,
                    "targets" => $targets,
                    "selectedTargets" => $targets_array,
                    "interests" => $interests,
                    "selectedInterest" => $interest_array,
                    "apperance" => null,
                    "relations" => null,
                    "chidren" => null,
                    "sechSettings" => $seachSettingsArray,
                    "smoking" => null,

            ]);
     * */
