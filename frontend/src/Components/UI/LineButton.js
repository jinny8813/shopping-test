import LineIcon from "./btn_base.png";

const LineButton = () => {
  const getLogin = () => {
    const url = process.env.REACT_APP_LINE_URL;
    window.location.href = url;
  };

  return (
    <div
      style={{
        display: "flex",
        height: "2.5rem",
        borderRadius: "5px",
        backgroundColor: "#06C755",
      }}
      onClick={getLogin}
    >
      <img
        src={LineIcon}
        style={{ borderRight: "1px solid rgb(0,0,0,8%)", padding: "1px" }}
      />
      <p
        style={{
          display: "flex",
          alignItems: "center",
          height: "100%",
          textAlign: "center",
          margin: "auto 28px",
          color: "white",
          fontSize: "14px",
          fontWeight: "bold",
        }}
      >
        Log in
      </p>
    </div>
  );
};

export default LineButton;
