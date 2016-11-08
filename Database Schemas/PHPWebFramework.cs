using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace PHPWebFramework
{
    #region Comments
    public class Comments
    {
        #region Member Variables
        protected int _id;
        protected int _postid;
        protected int _parentid;
        protected int _userid;
        protected int _timeposted;
        protected int _timeedited;
        protected string _description;
        protected int _currentnestedlevel;
        #endregion
        #region Constructors
        public Comments() { }
        public Comments(int postid, int parentid, int userid, int timeposted, int timeedited, string description, int currentnestedlevel)
        {
            this._postid=postid;
            this._parentid=parentid;
            this._userid=userid;
            this._timeposted=timeposted;
            this._timeedited=timeedited;
            this._description=description;
            this._currentnestedlevel=currentnestedlevel;
        }
        #endregion
        #region Public Properties
        public virtual int Id
        {
            get {return _id;}
            set {_id=value;}
        }
        public virtual int Postid
        {
            get {return _postid;}
            set {_postid=value;}
        }
        public virtual int Parentid
        {
            get {return _parentid;}
            set {_parentid=value;}
        }
        public virtual int Userid
        {
            get {return _userid;}
            set {_userid=value;}
        }
        public virtual int Timeposted
        {
            get {return _timeposted;}
            set {_timeposted=value;}
        }
        public virtual int Timeedited
        {
            get {return _timeedited;}
            set {_timeedited=value;}
        }
        public virtual string Description
        {
            get {return _description;}
            set {_description=value;}
        }
        public virtual int Currentnestedlevel
        {
            get {return _currentnestedlevel;}
            set {_currentnestedlevel=value;}
        }
        #endregion
    }
    #endregion
}using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace PHPWebFramework
{
    #region Facebook_users
    public class Facebook_users
    {
        #region Member Variables
        protected int _id;
        protected string _auth_id;
        protected string _email_address;
        protected int _joined;
        #endregion
        #region Constructors
        public Facebook_users() { }
        public Facebook_users(string auth_id, string email_address, int joined)
        {
            this._auth_id=auth_id;
            this._email_address=email_address;
            this._joined=joined;
        }
        #endregion
        #region Public Properties
        public virtual int Id
        {
            get {return _id;}
            set {_id=value;}
        }
        public virtual string Auth_id
        {
            get {return _auth_id;}
            set {_auth_id=value;}
        }
        public virtual string Email_address
        {
            get {return _email_address;}
            set {_email_address=value;}
        }
        public virtual int Joined
        {
            get {return _joined;}
            set {_joined=value;}
        }
        #endregion
    }
    #endregion
}using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace PHPWebFramework
{
    #region Google_users
    public class Google_users
    {
        #region Member Variables
        protected int _id;
        protected string _auth_id;
        protected string _email_address;
        protected int _joined;
        #endregion
        #region Constructors
        public Google_users() { }
        public Google_users(string auth_id, string email_address, int joined)
        {
            this._auth_id=auth_id;
            this._email_address=email_address;
            this._joined=joined;
        }
        #endregion
        #region Public Properties
        public virtual int Id
        {
            get {return _id;}
            set {_id=value;}
        }
        public virtual string Auth_id
        {
            get {return _auth_id;}
            set {_auth_id=value;}
        }
        public virtual string Email_address
        {
            get {return _email_address;}
            set {_email_address=value;}
        }
        public virtual int Joined
        {
            get {return _joined;}
            set {_joined=value;}
        }
        #endregion
    }
    #endregion
}using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace PHPWebFramework
{
    #region Users
    public class Users
    {
        #region Member Variables
        protected int _id;
        protected string _username;
        protected string _password;
        protected string _email_address;
        protected string _salt;
        protected int _joined;
        protected bool _activated;
        #endregion
        #region Constructors
        public Users() { }
        public Users(string username, string password, string email_address, string salt, int joined, bool activated)
        {
            this._username=username;
            this._password=password;
            this._email_address=email_address;
            this._salt=salt;
            this._joined=joined;
            this._activated=activated;
        }
        #endregion
        #region Public Properties
        public virtual int Id
        {
            get {return _id;}
            set {_id=value;}
        }
        public virtual string Username
        {
            get {return _username;}
            set {_username=value;}
        }
        public virtual string Password
        {
            get {return _password;}
            set {_password=value;}
        }
        public virtual string Email_address
        {
            get {return _email_address;}
            set {_email_address=value;}
        }
        public virtual string Salt
        {
            get {return _salt;}
            set {_salt=value;}
        }
        public virtual int Joined
        {
            get {return _joined;}
            set {_joined=value;}
        }
        public virtual bool Activated
        {
            get {return _activated;}
            set {_activated=value;}
        }
        #endregion
    }
    #endregion
}using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace PHPWebFramework
{
    #region Users_password_reset
    public class Users_password_reset
    {
        #region Member Variables
        protected int _id;
        protected string _username;
        protected string _salt;
        protected int _starttime;
        #endregion
        #region Constructors
        public Users_password_reset() { }
        public Users_password_reset(string username, string salt, int starttime)
        {
            this._username=username;
            this._salt=salt;
            this._starttime=starttime;
        }
        #endregion
        #region Public Properties
        public virtual int Id
        {
            get {return _id;}
            set {_id=value;}
        }
        public virtual string Username
        {
            get {return _username;}
            set {_username=value;}
        }
        public virtual string Salt
        {
            get {return _salt;}
            set {_salt=value;}
        }
        public virtual int Starttime
        {
            get {return _starttime;}
            set {_starttime=value;}
        }
        #endregion
    }
    #endregion
}using System;
using System.Collections;
using System.Collections.Generic;
using System.Text;
namespace PHPWebFramework
{
    #region Users_sessions
    public class Users_sessions
    {
        #region Member Variables
        protected int _id;
        protected int _user_id;
        protected string _hash;
        #endregion
        #region Constructors
        public Users_sessions() { }
        public Users_sessions(int user_id, string hash)
        {
            this._user_id=user_id;
            this._hash=hash;
        }
        #endregion
        #region Public Properties
        public virtual int Id
        {
            get {return _id;}
            set {_id=value;}
        }
        public virtual int User_id
        {
            get {return _user_id;}
            set {_user_id=value;}
        }
        public virtual string Hash
        {
            get {return _hash;}
            set {_hash=value;}
        }
        #endregion
    }
    #endregion
}