        $rules = [
            // 'name' => 'required|name|unique:roles',

            'name' => 'required|string|max:255|unique:roles',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
