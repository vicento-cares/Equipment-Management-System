USE [master]
GO
/****** Object:  Database [eems_db]    Script Date: 2026/06/04 2:39:43 pm ******/
CREATE DATABASE [eems_db]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'eems_db', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.SQLEXPRESS\MSSQL\DATA\eems_db.mdf' , SIZE = 8192KB , MAXSIZE = UNLIMITED, FILEGROWTH = 65536KB )
 LOG ON 
( NAME = N'eems_db_log', FILENAME = N'C:\Program Files\Microsoft SQL Server\MSSQL15.SQLEXPRESS\MSSQL\DATA\eems_db_log.ldf' , SIZE = 8192KB , MAXSIZE = 2048GB , FILEGROWTH = 65536KB )
 WITH CATALOG_COLLATION = DATABASE_DEFAULT
GO
ALTER DATABASE [eems_db] SET COMPATIBILITY_LEVEL = 150
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [eems_db].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [eems_db] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [eems_db] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [eems_db] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [eems_db] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [eems_db] SET ARITHABORT OFF 
GO
ALTER DATABASE [eems_db] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [eems_db] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [eems_db] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [eems_db] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [eems_db] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [eems_db] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [eems_db] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [eems_db] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [eems_db] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [eems_db] SET  DISABLE_BROKER 
GO
ALTER DATABASE [eems_db] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [eems_db] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [eems_db] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [eems_db] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [eems_db] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [eems_db] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [eems_db] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [eems_db] SET RECOVERY SIMPLE 
GO
ALTER DATABASE [eems_db] SET  MULTI_USER 
GO
ALTER DATABASE [eems_db] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [eems_db] SET DB_CHAINING OFF 
GO
ALTER DATABASE [eems_db] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [eems_db] SET TARGET_RECOVERY_TIME = 60 SECONDS 
GO
ALTER DATABASE [eems_db] SET DELAYED_DURABILITY = DISABLED 
GO
ALTER DATABASE [eems_db] SET ACCELERATED_DATABASE_RECOVERY = OFF  
GO
ALTER DATABASE [eems_db] SET QUERY_STORE = OFF
GO
USE [eems_db]
GO
/****** Object:  Table [dbo].[m_car_models]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_car_models](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_car_models] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_car_models_car_model] UNIQUE NONCLUSTERED 
(
	[car_model] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_line_no_final]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_line_no_final](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[section] [nvarchar](100) NULL,
	[location] [nvarchar](100) NOT NULL,
	[route_no] [varchar](10) NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_line_no_final] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_line_no_final_car_model] UNIQUE NONCLUSTERED 
(
	[car_model] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_line_no_initial]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_line_no_initial](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[section] [nvarchar](100) NULL,
	[location] [nvarchar](100) NOT NULL,
	[route_no] [nvarchar](10) NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_line_no_initial] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_line_no_initial_car_model] UNIQUE NONCLUSTERED 
(
	[car_model] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_locations]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_locations](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[location] [nvarchar](100) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_locations] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_locations_location] UNIQUE NONCLUSTERED 
(
	[location] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_machine_masterlist]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_machine_masterlist](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[number] [int] NOT NULL,
	[process] [nvarchar](10) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[machine_spec] [nvarchar](255) NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[location] [nvarchar](100) NOT NULL,
	[grid] [nvarchar](10) NULL,
	[machine_no] [nvarchar](255) NULL,
	[equipment_no] [nvarchar](255) NULL,
	[asset_tag_no] [nvarchar](255) NULL,
	[trd_no] [nvarchar](255) NULL,
	[ns_iv_no] [nvarchar](255) NULL,
	[machine_status] [nvarchar](100) NULL,
	[is_new] [tinyint] NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_machine_masterlist] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_machine_pm_accounts]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_machine_pm_accounts](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[username] [nvarchar](255) NOT NULL,
	[password] [nvarchar](255) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[role] [nvarchar](255) NOT NULL,
	[process] [nvarchar](10) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_machine_pm_accounts] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_machine_pm_accounts_username] UNIQUE NONCLUSTERED 
(
	[username] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_machine_setup_accounts]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_machine_setup_accounts](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[username] [nvarchar](255) NOT NULL,
	[password] [nvarchar](255) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[role] [nvarchar](255) NOT NULL,
	[approver_role] [nvarchar](255) NOT NULL,
	[process] [nvarchar](10) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_machine_setup_accounts] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_machine_setup_accounts_username] UNIQUE NONCLUSTERED 
(
	[username] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_machine_sp_accounts]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_machine_sp_accounts](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[username] [nvarchar](255) NOT NULL,
	[password] [nvarchar](255) NOT NULL,
	[name] [nvarchar](255) NOT NULL,
	[role] [nvarchar](255) NOT NULL,
	[approver_role] [nvarchar](255) NOT NULL,
	[process] [nvarchar](10) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_machine_sp_accounts] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_machine_sp_accounts_username] UNIQUE NONCLUSTERED 
(
	[username] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[m_machines]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[m_machines](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[number] [int] NOT NULL,
	[process] [nvarchar](10) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[trd] [tinyint] NOT NULL,
	[ns_iv] [tinyint] NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_machines] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_machines_machine_name] UNIQUE NONCLUSTERED 
(
	[machine_name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_fat_forms]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_fat_forms](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[fat_no] [nvarchar](255) NOT NULL,
	[item_name] [nvarchar](255) NOT NULL,
	[item_description] [nvarchar](255) NOT NULL,
	[machine_no] [nvarchar](255) NOT NULL,
	[equipment_no] [nvarchar](255) NOT NULL,
	[asset_tag_no] [nvarchar](255) NOT NULL,
	[prev_location_group] [nvarchar](255) NOT NULL,
	[prev_location_loc] [nvarchar](255) NOT NULL,
	[prev_location_grid] [nvarchar](255) NULL,
	[date_transfer] [date] NOT NULL,
	[new_location_group] [nvarchar](255) NOT NULL,
	[new_location_loc] [nvarchar](255) NOT NULL,
	[new_location_grid] [nvarchar](255) NOT NULL,
	[reason] [nvarchar](255) NOT NULL,
	[fat_status] [nvarchar](255) NOT NULL,
	[is_read_a3] [tinyint] NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_fat_forms] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_fat_forms_fat_no] UNIQUE NONCLUSTERED 
(
	[fat_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_machine_history]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_machine_history](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[number] [int] NOT NULL,
	[process] [nvarchar](10) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[machine_spec] [nvarchar](255) NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[location] [nvarchar](100) NOT NULL,
	[grid] [nvarchar](10) NOT NULL,
	[machine_no] [nvarchar](255) NULL,
	[equipment_no] [nvarchar](255) NULL,
	[asset_tag_no] [nvarchar](255) NULL,
	[trd_no] [nvarchar](255) NULL,
	[ns_iv_no] [nvarchar](255) NULL,
	[machine_status] [nvarchar](100) NOT NULL,
	[new_car_model] [nvarchar](255) NULL,
	[new_location] [nvarchar](100) NULL,
	[new_grid] [nvarchar](10) NULL,
	[pic] [nvarchar](255) NOT NULL,
	[status_date] [date] NOT NULL,
	[history_date_time] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_machine_history] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_machine_pm_concerns]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_machine_pm_concerns](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[pm_concern_id] [nvarchar](255) NOT NULL,
	[machine_line] [nvarchar](255) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[trd_no] [nvarchar](255) NULL,
	[ns_iv_no] [nvarchar](255) NULL,
	[problem] [nvarchar](255) NOT NULL,
	[request_by] [nvarchar](255) NOT NULL,
	[request_by_id_no] [nvarchar](255) NOT NULL,
	[concern_date_time] [datetime2](0) NOT NULL,
	[confirm_by] [nvarchar](255) NOT NULL,
	[confirm_by_username] [nvarchar](255) NOT NULL,
	[comment] [nvarchar](255) NOT NULL,
	[no_spare] [tinyint] NOT NULL,
	[no_of_parts] [int] NOT NULL,
	[status] [nvarchar](255) NOT NULL,
	[is_read] [tinyint] NOT NULL,
	[is_read_pm] [tinyint] NOT NULL,
	[is_read_sp] [tinyint] NOT NULL,
 CONSTRAINT [PK_machine_pm_concerns] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_machine_pm_concerns_pm_concern_id] UNIQUE NONCLUSTERED 
(
	[pm_concern_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_machine_pm_concerns_history]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_machine_pm_concerns_history](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[pm_concern_id] [nvarchar](255) NOT NULL,
	[machine_line] [nvarchar](255) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[trd_no] [nvarchar](255) NULL,
	[ns_iv_no] [nvarchar](255) NULL,
	[problem] [nvarchar](255) NOT NULL,
	[request_by] [nvarchar](255) NOT NULL,
	[request_by_id_no] [nvarchar](255) NOT NULL,
	[concern_date_time] [datetime2](0) NOT NULL,
	[confirm_by] [nvarchar](255) NOT NULL,
	[confirm_by_username] [nvarchar](255) NOT NULL,
	[comment] [nvarchar](255) NOT NULL,
	[no_spare] [tinyint] NOT NULL,
	[no_of_parts] [int] NOT NULL,
	[status] [nvarchar](255) NOT NULL,
	[is_read] [tinyint] NOT NULL,
	[is_read_pm] [tinyint] NOT NULL,
	[is_read_sp] [tinyint] NOT NULL,
 CONSTRAINT [PK_machine_pm_concerns_history] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_machine_pm_concerns_history_pm_concern_id] UNIQUE NONCLUSTERED 
(
	[pm_concern_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_machine_pm_docs]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_machine_pm_docs](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[process] [nvarchar](10) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[machine_docs_type] [nvarchar](255) NOT NULL,
	[file_name] [nvarchar](260) NOT NULL,
	[file_type] [nvarchar](255) NOT NULL,
	[file_url] [nvarchar](2048) NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_machine_pm_docs] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_machine_pm_no_spare]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_machine_pm_no_spare](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[pm_concern_id] [nvarchar](255) NOT NULL,
	[machine_line] [nvarchar](255) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[trd_no] [nvarchar](255) NULL,
	[ns_iv_no] [nvarchar](255) NULL,
	[problem] [nvarchar](255) NOT NULL,
	[request_by] [nvarchar](255) NOT NULL,
	[request_by_id_no] [nvarchar](255) NOT NULL,
	[concern_date_time] [datetime2](0) NOT NULL,
	[confirm_by] [nvarchar](255) NOT NULL,
	[confirm_by_username] [nvarchar](255) NOT NULL,
	[comment] [nvarchar](255) NOT NULL,
	[parts_code] [nvarchar](255) NOT NULL,
	[quantity] [int] NOT NULL,
	[po_date] [date] NULL,
	[po_no] [nvarchar](255) NULL,
	[no_spare_status] [nvarchar](255) NULL,
	[date_arrived] [date] NULL,
	[status] [nvarchar](255) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_machine_pm_no_spare] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_machine_pm_no_spare_history]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_machine_pm_no_spare_history](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[pm_concern_id] [nvarchar](255) NOT NULL,
	[machine_line] [nvarchar](255) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[trd_no] [nvarchar](255) NULL,
	[ns_iv_no] [nvarchar](255) NULL,
	[problem] [nvarchar](255) NOT NULL,
	[request_by] [nvarchar](255) NOT NULL,
	[request_by_id_no] [nvarchar](255) NOT NULL,
	[concern_date_time] [datetime2](0) NOT NULL,
	[confirm_by] [nvarchar](255) NOT NULL,
	[confirm_by_username] [nvarchar](255) NOT NULL,
	[comment] [nvarchar](255) NOT NULL,
	[parts_code] [nvarchar](255) NOT NULL,
	[quantity] [int] NOT NULL,
	[po_date] [date] NULL,
	[po_no] [nvarchar](255) NULL,
	[no_spare_status] [nvarchar](255) NULL,
	[date_arrived] [date] NULL,
	[status] [nvarchar](255) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_machine_pm_no_spare_history] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_machine_pm_plan]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_machine_pm_plan](
	[id] [int] NOT NULL,
	[number] [int] NOT NULL,
	[process] [nvarchar](10) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[machine_spec] [nvarchar](255) NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[location] [nvarchar](100) NOT NULL,
	[grid] [nvarchar](10) NULL,
	[machine_no] [nvarchar](255) NULL,
	[equipment_no] [nvarchar](255) NULL,
	[trd_no] [nvarchar](255) NULL,
	[ns_iv_no] [nvarchar](255) NULL,
	[pm_status] [nvarchar](100) NULL,
	[machine_status] [nvarchar](100) NULL,
	[internal_comment] [nvarchar](255) NULL,
	[ww_no] [nvarchar](10) NOT NULL,
	[frequency] [nvarchar](10) NOT NULL,
	[manpower] [nvarchar](255) NULL,
	[shift_engineer] [nvarchar](255) NULL,
	[pm_plan_comment] [nvarchar](255) NULL,
	[pm_plan_year] [nvarchar](4) NOT NULL,
	[ww_start_date] [date] NOT NULL,
	[ww_next_date] [date] NULL,
	[sched_start_date_time] [datetime2](0) NULL,
	[sched_end_date_time] [datetime2](0) NULL,
	[is_delayed] [tinyint] NOT NULL,
	[delay_frequency] [nvarchar](10) NULL,
	[delay_manpower] [nvarchar](255) NULL,
	[delay_start_date_time] [datetime] NULL,
	[delay_end_date_time] [datetime] NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_machine_pm_plan] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_machine_pm_wo]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_machine_pm_wo](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[wo_id] [nvarchar](255) NOT NULL,
	[process] [nvarchar](10) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[machine_no] [nvarchar](255) NOT NULL,
	[equipment_no] [nvarchar](255) NOT NULL,
	[file_name] [nvarchar](260) NOT NULL,
	[file_type] [nvarchar](255) NOT NULL,
	[file_url] [nvarchar](2048) NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_machine_pm_wo] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_machine_pm_wo_wo_id] UNIQUE NONCLUSTERED 
(
	[wo_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_machine_setup_activities]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_machine_setup_activities](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[requestor_name] [nvarchar](255) NOT NULL,
	[activity_details] [nvarchar](255) NOT NULL,
	[activity_status] [nvarchar](255) NOT NULL,
	[activity_date] [date] NOT NULL,
	[start_date_time] [datetime2](0) NOT NULL,
	[end_date_time] [datetime2](0) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
	[decline_reason] [nvarchar](255) NULL,
	[is_read] [tinyint] NOT NULL,
	[is_read_setup] [tinyint] NOT NULL,
 CONSTRAINT [PK_machine_setup_activities] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_machine_setup_docs]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_machine_setup_docs](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[process] [nvarchar](10) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[machine_docs_type] [nvarchar](255) NOT NULL,
	[file_name] [nvarchar](260) NOT NULL,
	[file_type] [nvarchar](255) NOT NULL,
	[file_url] [nvarchar](2048) NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_machine_setup_docs] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_notif_pm_approvers]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_notif_pm_approvers](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[interface] [nvarchar](100) NOT NULL,
	[pending_rsir] [tinyint] NOT NULL,
	[approved_rsir] [tinyint] NOT NULL,
	[disapproved_rsir] [tinyint] NOT NULL,
 CONSTRAINT [PK_notif_pm_approvers] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_notif_pm_concerns]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_notif_pm_concerns](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[interface] [nvarchar](100) NOT NULL,
	[new_pm_concerns] [tinyint] NOT NULL,
	[done_pm_concerns] [tinyint] NOT NULL,
	[pending_pm_concerns] [tinyint] NOT NULL,
 CONSTRAINT [PK_notif_pm_concerns] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_notif_pm_no_spare]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_notif_pm_no_spare](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[interface] [nvarchar](100) NOT NULL,
	[new_pm_concerns] [tinyint] NOT NULL,
 CONSTRAINT [PK_notif_pm_no_spare] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_notif_setup_activities]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_notif_setup_activities](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[interface] [nvarchar](100) NOT NULL,
	[new_act_sched] [tinyint] NOT NULL,
	[accepted_act_sched] [tinyint] NOT NULL,
	[declined_act_sched] [tinyint] NOT NULL,
 CONSTRAINT [PK_notif_setup_activities] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_notif_setup_approvers]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_notif_setup_approvers](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[interface] [nvarchar](100) NOT NULL,
	[pending_mstprc] [tinyint] NOT NULL,
	[approved_mstprc] [tinyint] NOT NULL,
	[disapproved_mstprc] [tinyint] NOT NULL,
 CONSTRAINT [PK_notif_setup_approvers] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_pm_rsir]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_pm_rsir](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[rsir_no] [nvarchar](255) NOT NULL,
	[rsir_type] [nvarchar](255) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[machine_no] [nvarchar](255) NULL,
	[equipment_no] [nvarchar](255) NOT NULL,
	[rsir_date] [date] NOT NULL,
	[judgement_of_eq] [nvarchar](255) NULL,
	[repair_details] [nvarchar](255) NOT NULL,
	[repaired_by] [nvarchar](255) NOT NULL,
	[repair_date] [date] NOT NULL,
	[next_pm_date] [date] NOT NULL,
	[judgement_of_prod] [nvarchar](255) NULL,
	[inspected_by] [nvarchar](255) NOT NULL,
	[confirmed_by] [nvarchar](255) NULL,
	[judgement_by] [nvarchar](255) NULL,
	[rsir_username] [nvarchar](255) NOT NULL,
	[rsir_approver_role] [nvarchar](255) NOT NULL,
	[rsir_process_status] [nvarchar](255) NOT NULL,
	[returned_by] [nvarchar](255) NULL,
	[returned_date_time] [datetime2](0) NULL,
	[disapproved_by] [nvarchar](255) NULL,
	[disapproved_by_role] [nvarchar](255) NULL,
	[disapproved_comment] [nvarchar](255) NULL,
	[is_read_pm] [tinyint] NOT NULL,
	[is_read_prod] [tinyint] NOT NULL,
	[is_read_qa] [tinyint] NOT NULL,
	[file_name] [nvarchar](260) NOT NULL,
	[file_type] [nvarchar](255) NOT NULL,
	[file_url] [nvarchar](2048) NULL,
	[rsir_eq_group] [nvarchar](255) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_pm_rsir] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_pm_rsir_rsir_no] UNIQUE NONCLUSTERED 
(
	[rsir_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_pm_rsir_history]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_pm_rsir_history](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[rsir_no] [nvarchar](255) NOT NULL,
	[rsir_type] [nvarchar](255) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[machine_no] [nvarchar](255) NULL,
	[equipment_no] [nvarchar](255) NOT NULL,
	[rsir_date] [date] NOT NULL,
	[judgement_of_eq] [nvarchar](255) NOT NULL,
	[repair_details] [nvarchar](255) NOT NULL,
	[repaired_by] [nvarchar](255) NOT NULL,
	[repair_date] [date] NOT NULL,
	[next_pm_date] [date] NOT NULL,
	[judgement_of_prod] [nvarchar](255) NOT NULL,
	[inspected_by] [nvarchar](255) NOT NULL,
	[confirmed_by] [nvarchar](255) NOT NULL,
	[judgement_by] [nvarchar](255) NULL,
	[rsir_username] [nvarchar](255) NOT NULL,
	[rsir_approver_role] [nvarchar](255) NOT NULL,
	[rsir_process_status] [nvarchar](255) NOT NULL,
	[returned_by] [nvarchar](255) NULL,
	[returned_date_time] [datetime2](0) NULL,
	[disapproved_by] [nvarchar](255) NULL,
	[disapproved_by_role] [nvarchar](255) NULL,
	[disapproved_comment] [nvarchar](255) NULL,
	[is_read_pm] [tinyint] NOT NULL,
	[is_read_prod] [tinyint] NOT NULL,
	[is_read_qa] [tinyint] NOT NULL,
	[file_name] [nvarchar](260) NOT NULL,
	[file_type] [nvarchar](255) NOT NULL,
	[file_url] [nvarchar](2048) NULL,
	[rsir_eq_group] [nvarchar](255) NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_pm_rsir_history] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_pm_rsir_history_rsir_no] UNIQUE NONCLUSTERED 
(
	[rsir_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_setup_mstprc]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_setup_mstprc](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[mstprc_no] [nvarchar](255) NOT NULL,
	[mstprc_type] [nvarchar](255) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[machine_no] [nvarchar](255) NOT NULL,
	[equipment_no] [nvarchar](255) NOT NULL,
	[mstprc_date] [date] NOT NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[location] [nvarchar](100) NOT NULL,
	[grid] [nvarchar](10) NOT NULL,
	[is_new] [tinyint] NOT NULL,
	[to_car_model] [nvarchar](255) NOT NULL,
	[to_location] [nvarchar](100) NOT NULL,
	[to_grid] [nvarchar](10) NOT NULL,
	[pullout_location] [nvarchar](255) NOT NULL,
	[transfer_reason] [nvarchar](255) NOT NULL,
	[pullout_reason] [nvarchar](255) NOT NULL,
	[mstprc_username] [nvarchar](255) NOT NULL,
	[mstprc_approver_role] [nvarchar](255) NOT NULL,
	[mstprc_eq_member] [nvarchar](255) NOT NULL,
	[mstprc_eq_g_leader] [nvarchar](255) NOT NULL,
	[mstprc_safety_officer] [nvarchar](255) NOT NULL,
	[mstprc_eq_manager] [nvarchar](255) NOT NULL,
	[mstprc_eq_sp_personnel] [nvarchar](255) NOT NULL,
	[mstprc_prod_engr_manager] [nvarchar](255) NOT NULL,
	[mstprc_prod_supervisor] [nvarchar](255) NOT NULL,
	[mstprc_prod_manager] [nvarchar](255) NOT NULL,
	[mstprc_qa_supervisor] [nvarchar](255) NOT NULL,
	[mstprc_qa_manager] [nvarchar](255) NOT NULL,
	[mstprc_process_status] [nvarchar](255) NOT NULL,
	[returned_by] [nvarchar](255) NOT NULL,
	[returned_date_time] [datetime] NULL,
	[disapproved_by] [nvarchar](255) NOT NULL,
	[disapproved_by_role] [nvarchar](255) NOT NULL,
	[disapproved_comment] [nvarchar](255) NOT NULL,
	[fat_no] [nvarchar](255) NOT NULL,
	[sou_no] [nvarchar](255) NOT NULL,
	[rsir_no] [nvarchar](255) NOT NULL,
	[is_read_setup] [tinyint] NOT NULL,
	[is_read_safety] [tinyint] NOT NULL,
	[is_read_eq_mgr] [tinyint] NOT NULL,
	[is_read_eq_sp] [tinyint] NOT NULL,
	[is_read_prod_engr_mgr] [tinyint] NOT NULL,
	[is_read_prod_sv] [tinyint] NOT NULL,
	[is_read_prod_mgr] [tinyint] NOT NULL,
	[is_read_qa_sv] [tinyint] NOT NULL,
	[is_read_qa_mgr] [tinyint] NOT NULL,
	[file_name] [nvarchar](260) NOT NULL,
	[file_type] [nvarchar](255) NOT NULL,
	[file_url] [nvarchar](2048) NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_setup_mstprc] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_setup_mstprc_mstprc_no] UNIQUE NONCLUSTERED 
(
	[mstprc_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_setup_mstprc_history]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_setup_mstprc_history](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[mstprc_no] [nvarchar](255) NOT NULL,
	[mstprc_type] [nvarchar](255) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[machine_no] [nvarchar](255) NOT NULL,
	[equipment_no] [nvarchar](255) NOT NULL,
	[mstprc_date] [date] NOT NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[location] [nvarchar](100) NOT NULL,
	[grid] [nvarchar](10) NOT NULL,
	[is_new] [tinyint] NOT NULL,
	[to_car_model] [nvarchar](255) NULL,
	[to_location] [nvarchar](100) NULL,
	[to_grid] [nvarchar](10) NULL,
	[pullout_location] [nvarchar](255) NULL,
	[transfer_reason] [nvarchar](255) NULL,
	[pullout_reason] [nvarchar](255) NULL,
	[mstprc_username] [nvarchar](255) NOT NULL,
	[mstprc_approver_role] [nvarchar](255) NOT NULL,
	[mstprc_eq_member] [nvarchar](255) NOT NULL,
	[mstprc_eq_g_leader] [nvarchar](255) NOT NULL,
	[mstprc_safety_officer] [nvarchar](255) NOT NULL,
	[mstprc_eq_manager] [nvarchar](255) NOT NULL,
	[mstprc_eq_sp_personnel] [nvarchar](255) NOT NULL,
	[mstprc_prod_engr_manager] [nvarchar](255) NOT NULL,
	[mstprc_prod_supervisor] [nvarchar](255) NOT NULL,
	[mstprc_prod_manager] [nvarchar](255) NOT NULL,
	[mstprc_qa_supervisor] [nvarchar](255) NULL,
	[mstprc_qa_manager] [nvarchar](255) NULL,
	[mstprc_process_status] [nvarchar](255) NOT NULL,
	[returned_by] [nvarchar](255) NULL,
	[returned_date_time] [datetime] NULL,
	[disapproved_by] [nvarchar](255) NULL,
	[disapproved_by_role] [nvarchar](255) NULL,
	[disapproved_comment] [nvarchar](255) NULL,
	[fat_no] [nvarchar](255) NOT NULL,
	[sou_no] [nvarchar](255) NOT NULL,
	[rsir_no] [nvarchar](255) NOT NULL,
	[is_read_setup] [tinyint] NOT NULL,
	[is_read_safety] [tinyint] NOT NULL,
	[is_read_eq_mgr] [tinyint] NOT NULL,
	[is_read_eq_sp] [tinyint] NOT NULL,
	[is_read_prod_engr_mgr] [tinyint] NOT NULL,
	[is_read_prod_sv] [tinyint] NOT NULL,
	[is_read_prod_mgr] [tinyint] NOT NULL,
	[is_read_qa_sv] [tinyint] NOT NULL,
	[is_read_qa_mgr] [tinyint] NOT NULL,
	[file_name] [nvarchar](260) NOT NULL,
	[file_type] [nvarchar](255) NOT NULL,
	[file_url] [nvarchar](2048) NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_setup_mstprc_history] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_setup_mstprc_history_mstprc_no] UNIQUE NONCLUSTERED 
(
	[mstprc_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_sou_forms]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_sou_forms](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[sou_no] [nvarchar](255) NOT NULL,
	[kigyo_no] [nvarchar](255) NOT NULL,
	[asset_name] [nvarchar](255) NOT NULL,
	[sup_asset_name] [nvarchar](255) NOT NULL,
	[orig_asset_no] [nvarchar](255) NOT NULL,
	[sou_date] [date] NOT NULL,
	[quantity] [int] NOT NULL,
	[managing_dept_code] [nvarchar](100) NOT NULL,
	[managing_dept_name] [nvarchar](255) NOT NULL,
	[install_area_code] [nvarchar](100) NOT NULL,
	[install_area_name] [nvarchar](255) NOT NULL,
	[machine_no] [nvarchar](255) NOT NULL,
	[equipment_no] [nvarchar](255) NOT NULL,
	[no_of_units] [int] NOT NULL,
	[ntc_or_sa] [nvarchar](255) NOT NULL,
	[use_purpose] [nvarchar](255) NOT NULL,
	[sou_status] [nvarchar](255) NOT NULL,
	[is_read_a3] [tinyint] NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_sou_forms] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY],
 CONSTRAINT [UX_sou_forms_sou_no] UNIQUE NONCLUSTERED 
(
	[sou_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[t_unused_machines]    Script Date: 2026/06/04 2:39:44 pm ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[t_unused_machines](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[machine_name] [nvarchar](255) NOT NULL,
	[car_model] [nvarchar](255) NOT NULL,
	[machine_no] [nvarchar](255) NOT NULL,
	[equipment_no] [nvarchar](255) NOT NULL,
	[asset_tag_no] [nvarchar](255) NULL,
	[unused_machine_location] [nvarchar](255) NULL,
	[status] [nvarchar](255) NULL,
	[reserved_for] [nvarchar](255) NULL,
	[pic] [nvarchar](255) NULL,
	[remarks] [nvarchar](255) NULL,
	[target_date] [datetime2](0) NULL,
	[sold] [tinyint] NOT NULL,
	[borrowed] [tinyint] NOT NULL,
	[disposed] [tinyint] NOT NULL,
	[date_updated] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_unused_machines] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [IX_pm_rsir_equipment_no]    Script Date: 2026/06/04 2:39:44 pm ******/
CREATE NONCLUSTERED INDEX [IX_pm_rsir_equipment_no] ON [dbo].[t_pm_rsir]
(
	[equipment_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [IX_pm_rsir_machine_no]    Script Date: 2026/06/04 2:39:44 pm ******/
CREATE NONCLUSTERED INDEX [IX_pm_rsir_machine_no] ON [dbo].[t_pm_rsir]
(
	[machine_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [IX_pm_rsir_history_equipment_no]    Script Date: 2026/06/04 2:39:44 pm ******/
CREATE NONCLUSTERED INDEX [IX_pm_rsir_history_equipment_no] ON [dbo].[t_pm_rsir_history]
(
	[equipment_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [IX_pm_rsir_history_machine_no]    Script Date: 2026/06/04 2:39:44 pm ******/
CREATE NONCLUSTERED INDEX [IX_pm_rsir_history_machine_no] ON [dbo].[t_pm_rsir_history]
(
	[machine_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [IX_setup_mstprc_equipment_no]    Script Date: 2026/06/04 2:39:44 pm ******/
CREATE NONCLUSTERED INDEX [IX_setup_mstprc_equipment_no] ON [dbo].[t_setup_mstprc]
(
	[equipment_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [IX_setup_mstprc_machine_name]    Script Date: 2026/06/04 2:39:44 pm ******/
CREATE NONCLUSTERED INDEX [IX_setup_mstprc_machine_name] ON [dbo].[t_setup_mstprc]
(
	[machine_name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [IX_setup_mstprc_machine_no]    Script Date: 2026/06/04 2:39:44 pm ******/
CREATE NONCLUSTERED INDEX [IX_setup_mstprc_machine_no] ON [dbo].[t_setup_mstprc]
(
	[machine_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [IX_setup_mstprc_history_equipment_no]    Script Date: 2026/06/04 2:39:44 pm ******/
CREATE NONCLUSTERED INDEX [IX_setup_mstprc_history_equipment_no] ON [dbo].[t_setup_mstprc_history]
(
	[equipment_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [IX_setup_mstprc_history_machine_no]    Script Date: 2026/06/04 2:39:44 pm ******/
CREATE NONCLUSTERED INDEX [IX_setup_mstprc_history_machine_no] ON [dbo].[t_setup_mstprc_history]
(
	[machine_no] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON, OPTIMIZE_FOR_SEQUENTIAL_KEY = OFF) ON [PRIMARY]
GO
ALTER TABLE [dbo].[m_car_models] ADD  CONSTRAINT [DF_car_models_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_line_no_final] ADD  CONSTRAINT [DF_line_no_final_route_no]  DEFAULT ('N/A') FOR [route_no]
GO
ALTER TABLE [dbo].[m_line_no_final] ADD  CONSTRAINT [DF_line_no_final_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_line_no_initial] ADD  CONSTRAINT [DF_line_no_initial_route_no]  DEFAULT (N'N/A') FOR [route_no]
GO
ALTER TABLE [dbo].[m_line_no_initial] ADD  CONSTRAINT [DF_line_no_initial_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_locations] ADD  CONSTRAINT [DF_locations_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_machine_masterlist] ADD  CONSTRAINT [DF_machine_masterlist_is_new]  DEFAULT ((1)) FOR [is_new]
GO
ALTER TABLE [dbo].[m_machine_masterlist] ADD  CONSTRAINT [DF_machine_masterlist_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_machine_pm_accounts] ADD  CONSTRAINT [DF_machine_pm_accounts_process]  DEFAULT (N'N/A') FOR [process]
GO
ALTER TABLE [dbo].[m_machine_pm_accounts] ADD  CONSTRAINT [DF_machine_pm_accounts_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_machine_setup_accounts] ADD  CONSTRAINT [DF_machine_setup_accounts_approver_role]  DEFAULT (N'N/A') FOR [approver_role]
GO
ALTER TABLE [dbo].[m_machine_setup_accounts] ADD  CONSTRAINT [DF_machine_setup_accounts_process]  DEFAULT (N'N/A') FOR [process]
GO
ALTER TABLE [dbo].[m_machine_setup_accounts] ADD  CONSTRAINT [DF_machine_setup_accounts_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_machine_sp_accounts] ADD  CONSTRAINT [DF_machine_sp_accounts_approver_role]  DEFAULT (N'N/A') FOR [approver_role]
GO
ALTER TABLE [dbo].[m_machine_sp_accounts] ADD  CONSTRAINT [DF_machine_sp_accounts_process]  DEFAULT (N'N/A') FOR [process]
GO
ALTER TABLE [dbo].[m_machine_sp_accounts] ADD  CONSTRAINT [DF_machine_sp_accounts_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[m_machines] ADD  CONSTRAINT [DF_machines_number]  DEFAULT ((0)) FOR [number]
GO
ALTER TABLE [dbo].[m_machines] ADD  CONSTRAINT [DF_machines_trd]  DEFAULT ((0)) FOR [trd]
GO
ALTER TABLE [dbo].[m_machines] ADD  CONSTRAINT [DF_machines_ns_iv]  DEFAULT ((0)) FOR [ns_iv]
GO
ALTER TABLE [dbo].[m_machines] ADD  CONSTRAINT [DF_machines_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_fat_forms] ADD  CONSTRAINT [DF_fat_forms_machine_no]  DEFAULT (N'N/A') FOR [machine_no]
GO
ALTER TABLE [dbo].[t_fat_forms] ADD  CONSTRAINT [DF_fat_forms_equipment_no]  DEFAULT (N'N/A') FOR [equipment_no]
GO
ALTER TABLE [dbo].[t_fat_forms] ADD  CONSTRAINT [DF_fat_forms_fat_status]  DEFAULT (N'Saved') FOR [fat_status]
GO
ALTER TABLE [dbo].[t_fat_forms] ADD  CONSTRAINT [DF_fat_forms_is_read_a3]  DEFAULT ((0)) FOR [is_read_a3]
GO
ALTER TABLE [dbo].[t_fat_forms] ADD  CONSTRAINT [DF_fat_forms_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_machine_history] ADD  CONSTRAINT [DF_machine_history_status_date]  DEFAULT (getdate()) FOR [status_date]
GO
ALTER TABLE [dbo].[t_machine_history] ADD  CONSTRAINT [DF_machine_history_history_date_time]  DEFAULT (getdate()) FOR [history_date_time]
GO
ALTER TABLE [dbo].[t_machine_pm_concerns] ADD  CONSTRAINT [DF_machine_pm_concerns_concern_date_time]  DEFAULT (getdate()) FOR [concern_date_time]
GO
ALTER TABLE [dbo].[t_machine_pm_concerns] ADD  CONSTRAINT [DF_machine_pm_concerns_no_spare]  DEFAULT ((0)) FOR [no_spare]
GO
ALTER TABLE [dbo].[t_machine_pm_concerns] ADD  CONSTRAINT [DF_machine_pm_concerns_no_of_parts]  DEFAULT ((0)) FOR [no_of_parts]
GO
ALTER TABLE [dbo].[t_machine_pm_concerns] ADD  CONSTRAINT [DF_machine_pm_concerns_is_read]  DEFAULT ((0)) FOR [is_read]
GO
ALTER TABLE [dbo].[t_machine_pm_concerns] ADD  CONSTRAINT [DF_machine_pm_concerns_is_read_pm]  DEFAULT ((0)) FOR [is_read_pm]
GO
ALTER TABLE [dbo].[t_machine_pm_concerns] ADD  CONSTRAINT [DF_machine_pm_concerns_is_read_sp]  DEFAULT ((0)) FOR [is_read_sp]
GO
ALTER TABLE [dbo].[t_machine_pm_concerns_history] ADD  CONSTRAINT [DF_machine_pm_concerns_history_concern_date_time]  DEFAULT (getdate()) FOR [concern_date_time]
GO
ALTER TABLE [dbo].[t_machine_pm_concerns_history] ADD  CONSTRAINT [DF_machine_pm_concerns_history_no_spare]  DEFAULT ((0)) FOR [no_spare]
GO
ALTER TABLE [dbo].[t_machine_pm_concerns_history] ADD  CONSTRAINT [DF_machine_pm_concerns_history_no_of_parts]  DEFAULT ((0)) FOR [no_of_parts]
GO
ALTER TABLE [dbo].[t_machine_pm_concerns_history] ADD  CONSTRAINT [DF_machine_pm_concerns_history_is_read]  DEFAULT ((0)) FOR [is_read]
GO
ALTER TABLE [dbo].[t_machine_pm_concerns_history] ADD  CONSTRAINT [DF_machine_pm_concerns_history_is_read_pm]  DEFAULT ((0)) FOR [is_read_pm]
GO
ALTER TABLE [dbo].[t_machine_pm_concerns_history] ADD  CONSTRAINT [DF_machine_pm_concerns_history_is_read_sp]  DEFAULT ((0)) FOR [is_read_sp]
GO
ALTER TABLE [dbo].[t_machine_pm_docs] ADD  CONSTRAINT [DF_machine_pm_docs_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_machine_pm_no_spare] ADD  CONSTRAINT [DF_machine_pm_no_spare_concern_date_time]  DEFAULT (getdate()) FOR [concern_date_time]
GO
ALTER TABLE [dbo].[t_machine_pm_no_spare] ADD  CONSTRAINT [DF_machine_pm_no_spare_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_machine_pm_no_spare_history] ADD  CONSTRAINT [DF_machine_pm_no_spare_history_concern_date_time]  DEFAULT (getdate()) FOR [concern_date_time]
GO
ALTER TABLE [dbo].[t_machine_pm_no_spare_history] ADD  CONSTRAINT [DF_machine_pm_no_spare_history_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_machine_pm_plan] ADD  CONSTRAINT [DF_machine_pm_plan_machine_no]  DEFAULT (N'N/A') FOR [machine_no]
GO
ALTER TABLE [dbo].[t_machine_pm_plan] ADD  CONSTRAINT [DF_machine_pm_plan_equipment_no]  DEFAULT (N'N/A') FOR [equipment_no]
GO
ALTER TABLE [dbo].[t_machine_pm_plan] ADD  CONSTRAINT [DF_machine_pm_plan_trd_no]  DEFAULT (N'N/A') FOR [trd_no]
GO
ALTER TABLE [dbo].[t_machine_pm_plan] ADD  CONSTRAINT [DF_machine_pm_plan_ns_iv_no]  DEFAULT (N'N/A') FOR [ns_iv_no]
GO
ALTER TABLE [dbo].[t_machine_pm_plan] ADD  CONSTRAINT [DF_machine_pm_plan_is_delayed]  DEFAULT ((0)) FOR [is_delayed]
GO
ALTER TABLE [dbo].[t_machine_pm_plan] ADD  CONSTRAINT [DF_machine_pm_plan_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_machine_pm_wo] ADD  CONSTRAINT [DF_machine_pm_wo_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_machine_setup_activities] ADD  CONSTRAINT [DF_machine_setup_activities_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_machine_setup_activities] ADD  CONSTRAINT [DF_machine_setup_activities_is_read]  DEFAULT ((0)) FOR [is_read]
GO
ALTER TABLE [dbo].[t_machine_setup_activities] ADD  CONSTRAINT [DF_machine_setup_activities_is_read_setup]  DEFAULT ((0)) FOR [is_read_setup]
GO
ALTER TABLE [dbo].[t_machine_setup_docs] ADD  CONSTRAINT [DF_machine_setup_docs_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_notif_pm_approvers] ADD  CONSTRAINT [DF_notif_pm_approvers_pending_rsir]  DEFAULT ((0)) FOR [pending_rsir]
GO
ALTER TABLE [dbo].[t_notif_pm_approvers] ADD  CONSTRAINT [DF_notif_pm_approvers_approved_rsir]  DEFAULT ((0)) FOR [approved_rsir]
GO
ALTER TABLE [dbo].[t_notif_pm_approvers] ADD  CONSTRAINT [DF_notif_pm_approvers_disapproved_rsir]  DEFAULT ((0)) FOR [disapproved_rsir]
GO
ALTER TABLE [dbo].[t_notif_pm_concerns] ADD  CONSTRAINT [DF_notif_pm_concerns_new_pm_concerns]  DEFAULT ((0)) FOR [new_pm_concerns]
GO
ALTER TABLE [dbo].[t_notif_pm_concerns] ADD  CONSTRAINT [DF_notif_pm_concerns_done_pm_concerns]  DEFAULT ((0)) FOR [done_pm_concerns]
GO
ALTER TABLE [dbo].[t_notif_pm_concerns] ADD  CONSTRAINT [DF_notif_pm_concerns_pending_pm_concerns]  DEFAULT ((0)) FOR [pending_pm_concerns]
GO
ALTER TABLE [dbo].[t_notif_pm_no_spare] ADD  CONSTRAINT [DF_notif_pm_no_spare_new_pm_concerns]  DEFAULT ((0)) FOR [new_pm_concerns]
GO
ALTER TABLE [dbo].[t_notif_setup_activities] ADD  CONSTRAINT [DF_notif_setup_activities_new_act_sched]  DEFAULT ((0)) FOR [new_act_sched]
GO
ALTER TABLE [dbo].[t_notif_setup_activities] ADD  CONSTRAINT [DF_notif_setup_activities_accepted_act_sched]  DEFAULT ((0)) FOR [accepted_act_sched]
GO
ALTER TABLE [dbo].[t_notif_setup_activities] ADD  CONSTRAINT [DF_notif_setup_activities_declined_act_sched]  DEFAULT ((0)) FOR [declined_act_sched]
GO
ALTER TABLE [dbo].[t_notif_setup_approvers] ADD  CONSTRAINT [DF_notif_setup_approvers_pending_mstprc]  DEFAULT ((0)) FOR [pending_mstprc]
GO
ALTER TABLE [dbo].[t_notif_setup_approvers] ADD  CONSTRAINT [DF_notif_setup_approvers_approved_mstprc]  DEFAULT ((0)) FOR [approved_mstprc]
GO
ALTER TABLE [dbo].[t_notif_setup_approvers] ADD  CONSTRAINT [DF_notif_setup_approvers_disapproved_mstprc]  DEFAULT ((0)) FOR [disapproved_mstprc]
GO
ALTER TABLE [dbo].[t_pm_rsir] ADD  CONSTRAINT [DF_pm_rsir_machine_no]  DEFAULT (N'N/A') FOR [machine_no]
GO
ALTER TABLE [dbo].[t_pm_rsir] ADD  CONSTRAINT [DF_pm_rsir_equipment_no]  DEFAULT (N'N/A') FOR [equipment_no]
GO
ALTER TABLE [dbo].[t_pm_rsir] ADD  CONSTRAINT [DF_pm_rsir_is_read_pm]  DEFAULT ((0)) FOR [is_read_pm]
GO
ALTER TABLE [dbo].[t_pm_rsir] ADD  CONSTRAINT [DF_pm_rsir_is_read_prod]  DEFAULT ((0)) FOR [is_read_prod]
GO
ALTER TABLE [dbo].[t_pm_rsir] ADD  CONSTRAINT [DF_pm_rsir_is_read_qa]  DEFAULT ((0)) FOR [is_read_qa]
GO
ALTER TABLE [dbo].[t_pm_rsir] ADD  CONSTRAINT [DF_pm_rsir_rsir_eq_group]  DEFAULT (N'pm') FOR [rsir_eq_group]
GO
ALTER TABLE [dbo].[t_pm_rsir] ADD  CONSTRAINT [DF_pm_rsir_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_pm_rsir_history] ADD  CONSTRAINT [DF_pm_rsir_history_machine_no]  DEFAULT (N'N/A') FOR [machine_no]
GO
ALTER TABLE [dbo].[t_pm_rsir_history] ADD  CONSTRAINT [DF_pm_rsir_history_equipment_no]  DEFAULT (N'N/A') FOR [equipment_no]
GO
ALTER TABLE [dbo].[t_pm_rsir_history] ADD  CONSTRAINT [DF_pm_rsir_history_is_read_pm]  DEFAULT ((0)) FOR [is_read_pm]
GO
ALTER TABLE [dbo].[t_pm_rsir_history] ADD  CONSTRAINT [DF_pm_rsir_history_is_read_prod]  DEFAULT ((0)) FOR [is_read_prod]
GO
ALTER TABLE [dbo].[t_pm_rsir_history] ADD  CONSTRAINT [DF_pm_rsir_history_is_read_qa]  DEFAULT ((0)) FOR [is_read_qa]
GO
ALTER TABLE [dbo].[t_pm_rsir_history] ADD  CONSTRAINT [DF_pm_rsir_history_rsir_eq_group]  DEFAULT (N'pm') FOR [rsir_eq_group]
GO
ALTER TABLE [dbo].[t_pm_rsir_history] ADD  CONSTRAINT [DF_pm_rsir_history_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_setup_mstprc] ADD  CONSTRAINT [DF_setup_mstprc_machine_no]  DEFAULT (N'N/A') FOR [machine_no]
GO
ALTER TABLE [dbo].[t_setup_mstprc] ADD  CONSTRAINT [DF_setup_mstprc_equipment_no]  DEFAULT (N'N/A') FOR [equipment_no]
GO
ALTER TABLE [dbo].[t_setup_mstprc] ADD  CONSTRAINT [DF_setup_mstprc_is_new]  DEFAULT ((0)) FOR [is_new]
GO
ALTER TABLE [dbo].[t_setup_mstprc] ADD  CONSTRAINT [DF_setup_mstprc_is_read_setup]  DEFAULT ((0)) FOR [is_read_setup]
GO
ALTER TABLE [dbo].[t_setup_mstprc] ADD  CONSTRAINT [DF_setup_mstprc_is_read_safety]  DEFAULT ((0)) FOR [is_read_safety]
GO
ALTER TABLE [dbo].[t_setup_mstprc] ADD  CONSTRAINT [DF_setup_mstprc_is_read_eq_mgr]  DEFAULT ((0)) FOR [is_read_eq_mgr]
GO
ALTER TABLE [dbo].[t_setup_mstprc] ADD  CONSTRAINT [DF_setup_mstprc_is_read_eq_sp]  DEFAULT ((0)) FOR [is_read_eq_sp]
GO
ALTER TABLE [dbo].[t_setup_mstprc] ADD  CONSTRAINT [DF_setup_mstprc_is_read_prod_engr_mgr]  DEFAULT ((0)) FOR [is_read_prod_engr_mgr]
GO
ALTER TABLE [dbo].[t_setup_mstprc] ADD  CONSTRAINT [DF_setup_mstprc_is_read_prod_sv]  DEFAULT ((0)) FOR [is_read_prod_sv]
GO
ALTER TABLE [dbo].[t_setup_mstprc] ADD  CONSTRAINT [DF_setup_mstprc_is_read_prod_mgr]  DEFAULT ((0)) FOR [is_read_prod_mgr]
GO
ALTER TABLE [dbo].[t_setup_mstprc] ADD  CONSTRAINT [DF_setup_mstprc_is_read_qa_sv]  DEFAULT ((0)) FOR [is_read_qa_sv]
GO
ALTER TABLE [dbo].[t_setup_mstprc] ADD  CONSTRAINT [DF_setup_mstprc_is_read_qa_mgr]  DEFAULT ((0)) FOR [is_read_qa_mgr]
GO
ALTER TABLE [dbo].[t_setup_mstprc] ADD  CONSTRAINT [DF_setup_mstprc_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_setup_mstprc_history] ADD  CONSTRAINT [DF_setup_mstprc_history_machine_no]  DEFAULT (N'N/A') FOR [machine_no]
GO
ALTER TABLE [dbo].[t_setup_mstprc_history] ADD  CONSTRAINT [DF_setup_mstprc_history_equipment_no]  DEFAULT (N'N/A') FOR [equipment_no]
GO
ALTER TABLE [dbo].[t_setup_mstprc_history] ADD  CONSTRAINT [DF_setup_mstprc_history_is_new]  DEFAULT ((0)) FOR [is_new]
GO
ALTER TABLE [dbo].[t_setup_mstprc_history] ADD  CONSTRAINT [DF_setup_mstprc_history_is_read_setup]  DEFAULT ((0)) FOR [is_read_setup]
GO
ALTER TABLE [dbo].[t_setup_mstprc_history] ADD  CONSTRAINT [DF_setup_mstprc_history_is_read_safety]  DEFAULT ((0)) FOR [is_read_safety]
GO
ALTER TABLE [dbo].[t_setup_mstprc_history] ADD  CONSTRAINT [DF_setup_mstprc_history_is_read_eq_mgr]  DEFAULT ((0)) FOR [is_read_eq_mgr]
GO
ALTER TABLE [dbo].[t_setup_mstprc_history] ADD  CONSTRAINT [DF_setup_mstprc_history_is_read_eq_sp]  DEFAULT ((0)) FOR [is_read_eq_sp]
GO
ALTER TABLE [dbo].[t_setup_mstprc_history] ADD  CONSTRAINT [DF_setup_mstprc_history_is_read_prod_engr_mgr]  DEFAULT ((0)) FOR [is_read_prod_engr_mgr]
GO
ALTER TABLE [dbo].[t_setup_mstprc_history] ADD  CONSTRAINT [DF_setup_mstprc_history_is_read_prod_sv]  DEFAULT ((0)) FOR [is_read_prod_sv]
GO
ALTER TABLE [dbo].[t_setup_mstprc_history] ADD  CONSTRAINT [DF_setup_mstprc_history_is_read_prod_mgr]  DEFAULT ((0)) FOR [is_read_prod_mgr]
GO
ALTER TABLE [dbo].[t_setup_mstprc_history] ADD  CONSTRAINT [DF_setup_mstprc_history_is_read_qa_sv]  DEFAULT ((0)) FOR [is_read_qa_sv]
GO
ALTER TABLE [dbo].[t_setup_mstprc_history] ADD  CONSTRAINT [DF_setup_mstprc_history_is_read_qa_mgr]  DEFAULT ((0)) FOR [is_read_qa_mgr]
GO
ALTER TABLE [dbo].[t_setup_mstprc_history] ADD  CONSTRAINT [DF_setup_mstprc_history_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_sou_forms] ADD  CONSTRAINT [DF_sou_forms_machine_no]  DEFAULT (N'N/A') FOR [machine_no]
GO
ALTER TABLE [dbo].[t_sou_forms] ADD  CONSTRAINT [DF_sou_forms_equipment_no]  DEFAULT (N'N/A') FOR [equipment_no]
GO
ALTER TABLE [dbo].[t_sou_forms] ADD  CONSTRAINT [DF_sou_forms_sou_status]  DEFAULT (N'Saved') FOR [sou_status]
GO
ALTER TABLE [dbo].[t_sou_forms] ADD  CONSTRAINT [DF_sou_forms_is_read_a3]  DEFAULT ((0)) FOR [is_read_a3]
GO
ALTER TABLE [dbo].[t_sou_forms] ADD  CONSTRAINT [DF_sou_forms_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
ALTER TABLE [dbo].[t_unused_machines] ADD  CONSTRAINT [DF_unused_machines_machine_no]  DEFAULT (N'N/A') FOR [machine_no]
GO
ALTER TABLE [dbo].[t_unused_machines] ADD  CONSTRAINT [DF_unused_machines_equipment_no]  DEFAULT (N'N/A') FOR [equipment_no]
GO
ALTER TABLE [dbo].[t_unused_machines] ADD  CONSTRAINT [DF_unused_machines_sold]  DEFAULT ((0)) FOR [sold]
GO
ALTER TABLE [dbo].[t_unused_machines] ADD  CONSTRAINT [DF_unused_machines_borrowed]  DEFAULT ((0)) FOR [borrowed]
GO
ALTER TABLE [dbo].[t_unused_machines] ADD  CONSTRAINT [DF_unused_machines_disposed]  DEFAULT ((0)) FOR [disposed]
GO
ALTER TABLE [dbo].[t_unused_machines] ADD  CONSTRAINT [DF_unused_machines_date_updated]  DEFAULT (getdate()) FOR [date_updated]
GO
USE [master]
GO
ALTER DATABASE [eems_db] SET  READ_WRITE 
GO
