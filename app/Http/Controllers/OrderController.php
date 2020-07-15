<?php

    namespace App\Http\Controllers;

    use App\OrderBuilder;
    use Illuminate\Http\Request;

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
            if ($item!=null) {
                return \response()->json([$item]);
            } else {
                return \response()->json([$orderBuilder]);
            }

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
