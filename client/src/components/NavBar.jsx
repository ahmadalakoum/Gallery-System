import React,{useState} from "react";
import { Link, useNavigate } from "react-router-dom";
import "./NavBar.css";

const NavBar = ({onSearch}) => {
  const userID = localStorage.getItem("userID");
  const username = localStorage.getItem("username");
  const [query, setQuery] = useState("");
  const navigate = useNavigate();
  const handleLogout = () => {
    localStorage.removeItem("userID");
    localStorage.removeItem("username");
    navigate('/login');
  };

  const handleChange = (event) => {
    const newQuery = event.target.value;
    setQuery(newQuery);
    onSearch(newQuery);
  };

  return (
    <nav className="navbar">
      <div className="logo">
        <Link to="/">PhotoApp</Link>
      </div>
      <input
        type="text"
        placeholder="Search..."
        className="search-input"
        value={query}
        onChange={handleChange}
      />
      <ul className="nav-links">
        <li>
          <Link to="/">Home</Link>
          <Link to="/add">Add</Link>
        </li>
        {userID ? (
          <>
            <li>
               {username}
            </li>
            <li>
              <button onClick={handleLogout} className="logout-btn">
                Logout
              </button>
            </li>
          </>
        ) : (
          <>
            <li>
              <Link to="/login">Login</Link>
            </li>
            <li>
              <Link to="/signup">Signup</Link>
            </li>
          </>
        )}
      </ul>
    </nav>
  );
};

export default NavBar;
