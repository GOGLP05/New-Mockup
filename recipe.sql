CREATE TABLE [dbo].[recipe](
	[recipe_id] [int] NOT NULL,
	[recipe_name] [varchar](40) NOT NULL,
	[recipe_file_path1] [varchar](max) NOT NULL,
	[recipe_file_path2] [varchar](max) NULL,
	[recipe_file_path3] [varchar](max) NULL,
	[process_1] [nvarchar](max) NOT NULL,
	[process_2] [nvarchar](max) NULL,
	[process_3] [nvarchar](max) NULL,
	[process_4] [nvarchar](max) NULL,
	[process_5] [nvarchar](max) NULL,
	[process_6] [nvarchar](max) NULL,
	[process_7] [nvarchar](max) NULL,
	[process_8] [nvarchar](max) NULL,
	[process_9] [nvarchar](max) NULL,
	[process_10] [nvarchar](max) NULL,
	[process_11] [nvarchar](max) NULL,
	[process_12] [nvarchar](max) NULL,
	[process_13] [nvarchar](max) NULL,
	[process_14] [nvarchar](max) NULL,
	[process_15] [nvarchar](max) NULL,
	[process_16] [nvarchar](max) NULL,
	[process_17] [nvarchar](max) NULL,
	[process_18] [nvarchar](max) NULL,
	[process_19] [nvarchar](max) NULL,
	[process_20] [nvarchar](max) NULL,
PRIMARY KEY CLUSTERED 
(
	[recipe_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]