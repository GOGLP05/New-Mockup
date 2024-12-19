CREATE TABLE FoodInventory
(
    food_id VARCHAR(8) NOT NULL,      -- �H�iID
    user_id VARCHAR(8) NOT NULL,      -- ���ID
    lot_no INT NOT NULL,              -- ���b�g�ԍ�
    food_name VARCHAR(40) NOT NULL,   -- �H�i��
    registration_date DATE NOT NULL,  -- �o�^��
    food_amount INT,                  -- ��
    food_gram INT,                    -- �O����
    expire_date DATE NOT NULL,        -- �g���؂�\��
    PRIMARY KEY (food_id, user_id, lot_no)  -- ��L�[�Ƃ��ĐH�iID�A���ID�A���b�g�ԍ��̑g�ݍ��킹
);