--
-- PostgreSQL database dump
--

\restrict edqbCLIAXaBIaWxnf3Bf6DswbcKIaFWKXhYjWzTvcxifZ2i4G8wcYEGWYrqU1bB

-- Dumped from database version 16.10 (Ubuntu 16.10-0ubuntu0.24.04.1)
-- Dumped by pg_dump version 16.10 (Ubuntu 16.10-0ubuntu0.24.04.1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: depts ; Type: TABLE; Schema: public; Owner: iatapadmin
--

CREATE TABLE public."depts " (
    id integer NOT NULL,
    description character varying,
    ids character varying
);


ALTER TABLE public."depts " OWNER TO iatapadmin;

--
-- Name: depts _id_seq; Type: SEQUENCE; Schema: public; Owner: iatapadmin
--

CREATE SEQUENCE public."depts _id_seq"
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public."depts _id_seq" OWNER TO iatapadmin;

--
-- Name: depts _id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iatapadmin
--

ALTER SEQUENCE public."depts _id_seq" OWNED BY public."depts ".id;


--
-- Name: ede_report; Type: TABLE; Schema: public; Owner: iatapadmin
--

CREATE TABLE public.ede_report (
    id integer NOT NULL,
    order_id character varying(15) NOT NULL,
    order_clin character varying(150) NOT NULL,
    order_no_mod character varying(150) NOT NULL,
    requisition_no character varying(255) NOT NULL,
    nsn_no character varying(150),
    order_qty integer NOT NULL,
    unit_price numeric(12,2) NOT NULL,
    order_date timestamp without time zone NOT NULL,
    due_date timestamp without time zone,
    recovery_date timestamp without time zone,
    ship_date timestamp without time zone,
    deliver_loc character varying(255),
    shipment character varying(255),
    tracking_no character varying(255),
    comments text,
    noun character varying(255) NOT NULL,
    part_no character varying(255) NOT NULL,
    vendor_name character varying(150) NOT NULL,
    vendor_cage_code character varying(50) NOT NULL,
    vendor_bus_size character varying(50) NOT NULL,
    qty_shipped integer,
    invoice_no character varying(30),
    finacial_impact character varying(30) NOT NULL,
    config_control_data character varying(30) DEFAULT 'N/A'::character varying NOT NULL,
    quality_control_data character varying(30) DEFAULT 'N/A'::character varying NOT NULL,
    risk_assessment_complete character varying(30) DEFAULT 'YES'::character varying NOT NULL,
    on_time_delivery character varying(30) DEFAULT 'MEDIUM'::character varying NOT NULL,
    labor_capacity character varying(30) DEFAULT 'LOW'::character varying NOT NULL,
    facility_capacity character varying(30) DEFAULT 'LOW'::character varying NOT NULL,
    supplier character varying(30) DEFAULT 'LOW'::character varying NOT NULL,
    product_liability character varying(30) DEFAULT 'LOW'::character varying NOT NULL,
    mitig_strat_a character varying(150) DEFAULT 'Notify expeditor to pay special attention to these orders and visit supplier as necessary.'::character varying NOT NULL,
    mitig_strat_b character varying(150) NOT NULL,
    mitig_strat_c character varying(150) DEFAULT 'No internal ATAP labor required except for packaging/shipping.'::character varying NOT NULL,
    mitig_strat_d character varying(255) DEFAULT 'ATAP facility adequate for this work.'::character varying NOT NULL,
    mitig_strat_e character varying(255) DEFAULT 'Known, approved vendor. Specified by customer'::character varying NOT NULL,
    mitig_strat_f character varying(255) DEFAULT 'Product and vendor approved and specified by customer. Not a new item.'::character varying NOT NULL,
    risk_rating_after_mit_a character varying(30) DEFAULT 'LOW'::character varying NOT NULL,
    risk_rating_after_mit_b character varying(30) DEFAULT 'LOW'::character varying NOT NULL,
    risk_rating_after_mit_c character varying(30) DEFAULT 'LOW'::character varying NOT NULL,
    risk_rating_after_mit_d character varying(30) DEFAULT 'LOW'::character varying NOT NULL,
    risk_rating_after_mit_e character varying(30) DEFAULT 'LOW'::character varying NOT NULL,
    risk_rating_after_mit_f character varying(30) DEFAULT 'LOW'::character varying NOT NULL,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone,
    oc character varying(5),
    sir character varying(25),
    sir_request_date character varying,
    sir_instructions_received_date character varying,
    tcn_tracking character varying
);


ALTER TABLE public.ede_report OWNER TO iatapadmin;

--
-- Name: ede_report_id_seq; Type: SEQUENCE; Schema: public; Owner: iatapadmin
--

CREATE SEQUENCE public.ede_report_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.ede_report_id_seq OWNER TO iatapadmin;

--
-- Name: ede_report_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iatapadmin
--

ALTER SEQUENCE public.ede_report_id_seq OWNED BY public.ede_report.id;


--
-- Name: employees; Type: TABLE; Schema: public; Owner: iatapadmin
--

CREATE TABLE public.employees (
    id bigint NOT NULL,
    employee_id integer,
    first_name character varying,
    last_name character varying,
    middle_initial character varying(2),
    addr_1 character varying,
    addr_2 character varying,
    addr_3 character varying,
    city character varying,
    state character varying,
    zipcode character varying,
    phone character varying,
    department_id integer,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone,
    hire_date date,
    birth_date date,
    vac_days integer,
    free_days integer,
    last_visual_updated_at timestamp without time zone,
    phone_2 character varying,
    contact_2 character varying,
    contact_2_relationship character varying,
    contact_2_primary character varying,
    contact_2_secondary character varying,
    contact_2_alternate character varying,
    work_email character varying,
    personal_email character varying,
    "group" character varying,
    contact_3 character varying,
    contact_3_relationship character varying,
    contact_3_primary character varying,
    contact_3_secondary character varying,
    contact_3_alternate character varying
);


ALTER TABLE public.employees OWNER TO iatapadmin;

--
-- Name: employees_id_seq; Type: SEQUENCE; Schema: public; Owner: iatapadmin
--

CREATE SEQUENCE public.employees_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.employees_id_seq OWNER TO iatapadmin;

--
-- Name: employees_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iatapadmin
--

ALTER SEQUENCE public.employees_id_seq OWNED BY public.employees.id;


--
-- Name: operations_cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.operations_cache (
    id integer NOT NULL,
    type character(1) NOT NULL,
    base_id character varying(20) NOT NULL,
    lot_id integer NOT NULL,
    split_id integer NOT NULL,
    sub_id integer NOT NULL,
    sequence_no integer NOT NULL,
    resource_id character varying(20) NOT NULL,
    run numeric(10,2),
    run_type character varying(20),
    run_hrs numeric(10,2),
    service_id character varying(20),
    calc_start_qty numeric(10,2),
    calc_end_qty numeric(10,2),
    completed_qty numeric(10,2),
    act_run_hrs numeric(10,2),
    status character(1),
    setup_completed character(1),
    close_date date,
    sched_start_date date,
    sched_finish_date date,
    could_finish_date date,
    est_atl_lab_cost numeric(12,2),
    est_atl_bur_cost numeric(12,2),
    est_atl_ser_cost numeric(12,2),
    rem_atl_lab_cost numeric(12,2),
    rem_atl_bur_cost numeric(12,2),
    rem_atl_ser_cost numeric(12,2),
    act_atl_lab_cost numeric(12,2),
    act_atl_bur_cost numeric(12,2),
    act_atl_ser_cost numeric(12,2),
    est_ttl_mat_cost numeric(12,2),
    est_ttl_lab_cost numeric(12,2),
    est_ttl_bur_cost numeric(12,2),
    rem_ttl_mat_cost numeric(12,2),
    rem_ttl_lab_cost numeric(12,2),
    rem_ttl_bur_cost numeric(12,2),
    rem_ttl_ser_cost numeric(12,2),
    act_ttl_mat_cost numeric(12,2),
    act_ttl_lab_cost numeric(12,2),
    act_ttl_bur_cost numeric(12,2),
    act_ttl_ser_cost numeric(12,2),
    vendor_id character varying(20),
    vendor_service_id character varying(20),
    created_at timestamp without time zone DEFAULT now()
);


ALTER TABLE public.operations_cache OWNER TO postgres;

--
-- Name: operation_cache_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.operation_cache_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.operation_cache_id_seq OWNER TO postgres;

--
-- Name: operation_cache_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.operation_cache_id_seq OWNED BY public.operations_cache.id;


--
-- Name: purchase_order_lines; Type: TABLE; Schema: public; Owner: iatapadmin
--

CREATE TABLE public.purchase_order_lines (
);


ALTER TABLE public.purchase_order_lines OWNER TO iatapadmin;

--
-- Name: purchase_orders; Type: TABLE; Schema: public; Owner: iatapadmin
--

CREATE TABLE public.purchase_orders (
    id character varying NOT NULL,
    vendor_id text,
    name text,
    order_date date,
    contract_date date,
    desired_recv_date date,
    terms integer,
    confirmed text,
    buyer text,
    status text,
    phone text,
    email text,
    contact_first_name text,
    contact_last_name text,
    linear_progress integer,
    lead_time_days integer,
    elapsed_days integer,
    days_left integer,
    true_promise date,
    is_late boolean,
    percentage_complete integer,
    color text,
    status_label text,
    followup_25_target_date date,
    followup_50_target_date date,
    followup_90_target_date date,
    followup_25_updated_at date,
    followup_50_updated_at date,
    followup_90_updated_at date,
    last_vendor_update_at date,
    next_vendor_update_at date,
    created_at timestamp without time zone,
    updated_at timestamp without time zone,
    deleted_at timestamp without time zone
);


ALTER TABLE public.purchase_orders OWNER TO iatapadmin;

--
-- Name: requirements_cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.requirements_cache (
    id integer NOT NULL,
    base_id character varying(20) NOT NULL,
    sub_id integer NOT NULL,
    seq_no integer NOT NULL,
    suborder_sub_id character varying(20),
    part_id character varying(60) NOT NULL,
    description text,
    planner_id character varying(20),
    qty_per numeric(10,2),
    issued_qty numeric(10,2),
    calc_qty numeric(10,2),
    qty_on_hand numeric(10,2),
    qty_on_order numeric(10,2),
    status character(1),
    created_at timestamp without time zone DEFAULT now(),
    piece_no character varying(5),
    resource_id character varying(10)
);


ALTER TABLE public.requirements_cache OWNER TO postgres;

--
-- Name: requirement_cache_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.requirement_cache_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.requirement_cache_id_seq OWNER TO postgres;

--
-- Name: requirement_cache_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.requirement_cache_id_seq OWNED BY public.requirements_cache.id;


--
-- Name: vendor_cache; Type: TABLE; Schema: public; Owner: iatapadmin
--

CREATE TABLE public.vendor_cache (
    id bigint NOT NULL,
    vendor_id text NOT NULL,
    name text NOT NULL,
    street_1 text,
    street_2 text,
    city text,
    state character(2),
    zip text,
    phone text,
    email text,
    open_date date,
    modify_date date,
    total_lines integer,
    total_on_time integer,
    total_late integer,
    on_time_percentage integer,
    late_percentage integer,
    start_date date,
    end_date date,
    bg_color text,
    late_bg_color text,
    ncp integer,
    jcp_expiration character varying
);


ALTER TABLE public.vendor_cache OWNER TO iatapadmin;

--
-- Name: vendor_cache_id_seq; Type: SEQUENCE; Schema: public; Owner: iatapadmin
--

CREATE SEQUENCE public.vendor_cache_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.vendor_cache_id_seq OWNER TO iatapadmin;

--
-- Name: vendor_cache_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iatapadmin
--

ALTER SEQUENCE public.vendor_cache_id_seq OWNED BY public.vendor_cache.id;


--
-- Name: vendor_performance_cache; Type: TABLE; Schema: public; Owner: iatapadmin
--

CREATE TABLE public.vendor_performance_cache (
    id integer NOT NULL,
    vendor_id text,
    vendor_name text,
    email text,
    total integer,
    on_time integer,
    late integer,
    percent double precision,
    "timestamp" timestamp without time zone
);


ALTER TABLE public.vendor_performance_cache OWNER TO iatapadmin;

--
-- Name: vendor_performance_cache_id_seq; Type: SEQUENCE; Schema: public; Owner: iatapadmin
--

CREATE SEQUENCE public.vendor_performance_cache_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.vendor_performance_cache_id_seq OWNER TO iatapadmin;

--
-- Name: vendor_performance_cache_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iatapadmin
--

ALTER SEQUENCE public.vendor_performance_cache_id_seq OWNED BY public.vendor_performance_cache.id;


--
-- Name: workorder_cache; Type: TABLE; Schema: public; Owner: iatapadmin
--

CREATE TABLE public.workorder_cache (
    id integer NOT NULL,
    type character varying(2),
    base_id character varying(20) NOT NULL,
    sub_id integer NOT NULL,
    status character varying(1),
    part_id character varying(40),
    desired_qty numeric(12,3),
    received_qty numeric(12,3),
    created_date date,
    want_date date,
    description text,
    qty_on_hand numeric(12,3),
    qty_on_order numeric(12,3),
    qty_in_demand numeric(12,3),
    created_at timestamp without time zone DEFAULT now(),
    order_link character varying(60),
    drawing_requirement character varying(60),
    dpas_rating character varying(60),
    promise_date character varying(60),
    contract_no character varying(60)
);


ALTER TABLE public.workorder_cache OWNER TO iatapadmin;

--
-- Name: workorder_cache_id_seq; Type: SEQUENCE; Schema: public; Owner: iatapadmin
--

CREATE SEQUENCE public.workorder_cache_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.workorder_cache_id_seq OWNER TO iatapadmin;

--
-- Name: workorder_cache_id_seq1; Type: SEQUENCE; Schema: public; Owner: iatapadmin
--

ALTER TABLE public.workorder_cache ALTER COLUMN id ADD GENERATED BY DEFAULT AS IDENTITY (
    SEQUENCE NAME public.workorder_cache_id_seq1
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- Name: depts  id; Type: DEFAULT; Schema: public; Owner: iatapadmin
--

ALTER TABLE ONLY public."depts " ALTER COLUMN id SET DEFAULT nextval('public."depts _id_seq"'::regclass);


--
-- Name: ede_report id; Type: DEFAULT; Schema: public; Owner: iatapadmin
--

ALTER TABLE ONLY public.ede_report ALTER COLUMN id SET DEFAULT nextval('public.ede_report_id_seq'::regclass);


--
-- Name: employees id; Type: DEFAULT; Schema: public; Owner: iatapadmin
--

ALTER TABLE ONLY public.employees ALTER COLUMN id SET DEFAULT nextval('public.employees_id_seq'::regclass);


--
-- Name: operations_cache id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.operations_cache ALTER COLUMN id SET DEFAULT nextval('public.operation_cache_id_seq'::regclass);


--
-- Name: requirements_cache id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.requirements_cache ALTER COLUMN id SET DEFAULT nextval('public.requirement_cache_id_seq'::regclass);


--
-- Name: vendor_cache id; Type: DEFAULT; Schema: public; Owner: iatapadmin
--

ALTER TABLE ONLY public.vendor_cache ALTER COLUMN id SET DEFAULT nextval('public.vendor_cache_id_seq'::regclass);


--
-- Name: vendor_performance_cache id; Type: DEFAULT; Schema: public; Owner: iatapadmin
--

ALTER TABLE ONLY public.vendor_performance_cache ALTER COLUMN id SET DEFAULT nextval('public.vendor_performance_cache_id_seq'::regclass);


--
-- Name: depts  depts _pkey; Type: CONSTRAINT; Schema: public; Owner: iatapadmin
--

ALTER TABLE ONLY public."depts "
    ADD CONSTRAINT "depts _pkey" PRIMARY KEY (id);


--
-- Name: employees employees_pkey; Type: CONSTRAINT; Schema: public; Owner: iatapadmin
--

ALTER TABLE ONLY public.employees
    ADD CONSTRAINT employees_pkey PRIMARY KEY (id);


--
-- Name: operations_cache operation_cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.operations_cache
    ADD CONSTRAINT operation_cache_pkey PRIMARY KEY (id);


--
-- Name: ede_report pk_ede_report; Type: CONSTRAINT; Schema: public; Owner: iatapadmin
--

ALTER TABLE ONLY public.ede_report
    ADD CONSTRAINT pk_ede_report PRIMARY KEY (id);


--
-- Name: purchase_orders purchase_orders_pkey; Type: CONSTRAINT; Schema: public; Owner: iatapadmin
--

ALTER TABLE ONLY public.purchase_orders
    ADD CONSTRAINT purchase_orders_pkey PRIMARY KEY (id);


--
-- Name: requirements_cache requirement_cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.requirements_cache
    ADD CONSTRAINT requirement_cache_pkey PRIMARY KEY (id);


--
-- Name: vendor_cache vendor_cache_pkey; Type: CONSTRAINT; Schema: public; Owner: iatapadmin
--

ALTER TABLE ONLY public.vendor_cache
    ADD CONSTRAINT vendor_cache_pkey PRIMARY KEY (id);


--
-- Name: vendor_performance_cache vendor_performance_cache_pkey; Type: CONSTRAINT; Schema: public; Owner: iatapadmin
--

ALTER TABLE ONLY public.vendor_performance_cache
    ADD CONSTRAINT vendor_performance_cache_pkey PRIMARY KEY (id);


--
-- Name: workorder_cache workorder_cache_pkey; Type: CONSTRAINT; Schema: public; Owner: iatapadmin
--

ALTER TABLE ONLY public.workorder_cache
    ADD CONSTRAINT workorder_cache_pkey PRIMARY KEY (id);


--
-- Name: idx_resource_id; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_resource_id ON public.operations_cache USING btree (resource_id);


--
-- Name: idx_status; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_status ON public.operations_cache USING btree (status);


--
-- Name: idx_workorder_base_sub_seq; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_workorder_base_sub_seq ON public.operations_cache USING btree (base_id, sub_id, sequence_no);


--
-- PostgreSQL database dump complete
--

\unrestrict edqbCLIAXaBIaWxnf3Bf6DswbcKIaFWKXhYjWzTvcxifZ2i4G8wcYEGWYrqU1bB

