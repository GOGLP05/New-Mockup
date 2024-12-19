CREATE TABLE [dbo].[food_master](
	[food_id] [int] NOT NULL,
	[food_name] [varchar](40) NOT NULL,
	[expiry_date] [int] NOT NULL,
	[food_file_path] [varchar](255) NULL,
	[category_id] [int] NOT NULL,
	[standard_gram] [int] NULL,
 CONSTRAINT [PK_food] PRIMARY KEY CLUSTERED 
(
	[food_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]