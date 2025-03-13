import React, {useState} from 'react'
import { signup } from '../../services/api';
import "./SignupForm.css";
import {useNavigate} from "react-router-dom";
const SignupForm = () => {
  const navigate = useNavigate();
    const [username,setUsername]=useState('');
    const [email,setEmail]= useState('');
    const [password,setPassword]=useState('');
     const [error,setError]=useState('');
    const handleSignup = async (e)=>{
        e.preventDefault();
        const data = await signup({username,email,password});
      
        if(data.status==='success'){
            navigate('/login');
        }else{
            setError(data.message)
        }
    }
  return (
    <div className="signup-container">
    <div className="signup-box">
      <h2>Sign Up</h2>
      <form onSubmit={handleSignup}>
        <input
          type="text"
          placeholder="Username"
          value={username}
          onChange={(e) => setUsername(e.target.value)}
          required
        />
        <input
          type="email"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
          required
        />
        <input
          type="password"
          placeholder="Password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
          required
        />
        <button type="submit">Sign Up</button>
      </form>
      {error && <div className="error-message">{error}</div>}
    </div>
  </div>
  )
}

export default SignupForm