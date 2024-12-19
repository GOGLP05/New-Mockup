CREATE TABLE FoodInventory
(
    food_id VARCHAR(8) NOT NULL,      -- 食品ID
    user_id VARCHAR(8) NOT NULL,      -- 会員ID
    lot_no INT NOT NULL,              -- ロット番号
    food_name VARCHAR(40) NOT NULL,   -- 食品名
    registration_date DATE NOT NULL,  -- 登録日
    food_amount INT,                  -- 個数
    food_gram INT,                    -- グラム
    expire_date DATE NOT NULL,        -- 使い切り予定
    PRIMARY KEY (food_id, user_id, lot_no)  -- 主キーとして食品ID、会員ID、ロット番号の組み合わせ
);