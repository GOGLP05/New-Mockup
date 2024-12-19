CREATE TABLE [dbo].[recipe_ingredients](
	[recipe_id] [int] NOT NULL,
	[food_id] [int] NOT NULL,
	[display_use] [int] NULL,
	[calculation_use] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[recipe_id] ASC,
	[food_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]